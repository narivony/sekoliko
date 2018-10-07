<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoDashboard;

use App\Sekoliko\Service\MetierManagerBundle\Form\SekolikoProjetLotTacheStatutType;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\TacheStatusName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\Util;
use App\Sekoliko\Service\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class ServiceMetierDashboard
 * @package App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoEspacePersonnel
 */
class ServiceMetierDashboard
{
    private $_entity_manager;
    private $_container;

    /**
     * ServiceMetierDashboard constructor.
     * @param EntityManager $_entity_manager
     * @param Container $_container
     */
    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Envoie email pour les responsable du projet et le personnel si le compte a rebour est atteint
     * @param $_data
     * @return bool
     */
    public function sendMailChrono($_data)
    {
        // Recuperer le manager
        $_utils_manager = $this->_container->get(ServiceName::SRV_METIER_UTILS);
        $_cible_tache   = $_utils_manager->getEntityById(EntityName::Sekoliko_PROJET_LOT_TACHE, $_data['task_id']);
        $_lot_tache     = $_cible_tache->getSekolikoProjetLot();
        $_response      = false;

        if($_lot_tache && $_cible_tache->getSekolikoUser()) {
            $_lot_users = $_cible_tache->getSekolikoProjetLot()->getSekolikoProjetLotEquipe();
            if(count($_lot_users) > 0){
                $_recipients = [];
                foreach ($_lot_users as $_list)
                    if ($_list->getPrjLotEqpIsResponsable())
                        array_push($_recipients, $_list->getSekolikoUser()->getEmail());

                $_template   = 'AdminBundle:SekolikoProjetLotTache:SekolikoPrjLtTchEmail/email_compte_rebour.html.twig';
                $_data_param = ['tache' => $_cible_tache, 'type' => $_data['alert_type']];

                if($_data['alert_type'] == 'responsable') {
                    $_cible_tache->setPrjLotTchIsMailSendResp(true);
                    $_subject    = 'Estimation responsable atteint';

                    $_response = $_utils_manager->sendMail($_recipients, $_subject, $_template, $_data_param);
                }

                if($_data['alert_type'] == 'personnel'){
                    $_cible_tache->setPrjLotTchIsMailSendPers(true);
                    $_subject   = 'Estimation personnel atteint';
                    $_recipient = $_cible_tache->getSekolikoUser()->getEmail();

                    $_response = $_utils_manager->sendMail($_recipient, $_subject, $_template, $_data_param, $_recipients);
                }

                $_utils_manager->saveEntity($_cible_tache, 'update');
            }

        }

        return $_response;
    }

    /*
     * ============================================================
     * Debut - Pagination en mode chargement - Liste des evenements
     * ============================================================
     */
    /**
     * Filtre
     * @param Request $_request
     * @return array
     */
    public function getFilters($_request)
    {
        $_filters = array();
        $_start   = $_request->query->get('iDisplayStart');
        $_length  = $_request->query->get('iDisplayLength');

        if (isset($_start)) {
            $_filters['start'] = (int) $_start;
        }
        if (isset($_length)) {
            $_filters['length'] = (int) $_length;
        }

        return $_filters;
    }

    /**
     * Triage
     * @param Request $_request
     * @param array $_columns
     * @return array
     */
    public function getSortings($_request, $_columns)
    {
        $_sortings = array();

        foreach ($_columns as $_k => $_v) {
            $_is_sort_col = $_request->query->get('iSortCol_' . $_k);
            if (isset($_is_sort_col) && $_columns[$_is_sort_col]) {
                $_order_column = $_columns[$_is_sort_col];
                $_sort_dir = $_request->query->get('sSortDir_' . $_k);
                if (isset($_sort_dir) && $_sort_dir == 'asc') {
                    $_order_direction = 'ASC';
                } else {
                    $_order_direction = 'DESC';
                }

                $_sortings[$_order_column] = $_order_direction;
            }
        }

        return $_sortings;
    }

    /**
     * Recuperer le nombre total d enregistrement
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNbSekolikoEventQueryBuilder($_options = null)
    {
        $_qb = $this->findByQueryBuilder($_options);

        return $_qb->select('COUNT(DISTINCT usr_evt.id) AS nb');

    }

    /**
     * Limite sql
     * @param object $_qb
     * @param array $_limit
     * @return mixed
     */
    public function addLimit($_qb, $_limit = array())
    {
        if (isset($_limit['start'])) {
            $_qb->setFirstResult($_limit['start']);
        }
        if (isset($_limit['length'])) {
            $_qb->setMaxResults($_limit['length']);
        }

        return $_qb;
    }

    /**
     * Triage des donnees
     * @param object $_qb
     * @param array $_sortings
     * @return mixed
     */
    public function addSortings($_qb, $_sortings = [])
    {
        if (isset($_sortings['isOrderRand'])) {
            $_qb
                ->addSelect('RAND() as HIDDEN rand')
                ->orderBy('rand');
        } else {
            if (count($_sortings) == 0) {
                $_qb->groupBy('usr_evt.id');
                $_qb->orderBy('usr_evt.id', 'DESC');
            } else {
                foreach ($_sortings as $_sorting_column => $_sorting_direction) {
                    $_qb->groupBy('usr_evt.id');
                    $_qb->addOrderBy($_sorting_column, $_sorting_direction);
                }
            }
        }

        return $_qb;
    }

    /**
     * Ajout filtre
     * @param null $_query
     * @param array $_filters
     * @return null
     */
    public function addFilters($_query = null, $_filters = [])
    {
        return $_query;
    }

    /**
     * Recuperer tout les projet lot taches
     * @param array $_options
     * @param array $_filters
     * @param array $_sortings
     * @return mixed
     */
    public function getAllSekolikoEventBy($_options, $_filters = [], $_sortings = [])
    {
        $_query = $this->findByQueryBuilder($_options);
        $_query = $this->addFilters($_query, $_filters);
        $_query = $this->addSortings($_query, $_sortings);

        if ($_filters != null) {
            $_query = $this->addLimit($_query, $_filters);
        }

        return $_query->getQuery()->getResult();
    }

    /**
     * Recuperer le nombre d enregistrement
     * @param array $_options
     * @param array $_filters
     * @return mixed
     */
    public function getNbSekolikoEventBy($_options = [], $_filters = [])
    {
        $_query = $this->getNbSekolikoEventQueryBuilder($_options);

        return $_query->getQuery()->getSingleResult();
    }

    /**
     * Filtre de recherche
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder($_options = null)
    {
        $_event_user = EntityName::Sekoliko_USER_ABSENCE;

        $_qb = $this->_entity_manager
            ->createQueryBuilder('usr_evt')
            ->select('usr_evt')
            ->from($_event_user, 'usr_evt')
            ->leftJoin('usr_evt.sekolikoUserAbsenceType', 'evt_tp')
            ->leftJoin('usr_evt.sekolikoUser','usr')
        ;

        // Filtre utilisateur
        if (isset($_options['filtre_utilisateur']) && !empty($_options['filtre_utilisateur'])) {
            $_qb->andWhere('usr.id = :user_id')
                ->setParameter('user_id', $_options['filtre_utilisateur']);
        }

        // Filtre recherche
        if (isset($_options['search'])) {
            $_qb->andWhere('evt_tp.usrAbsTpLibelle LIKE :evt_usr_abs_typ 
             OR usr.usrFirstname LIKE :usr_firstname OR usr.usrLastname LIKE :usr_lastname 
             OR usr_evt.usrAbsMotif LIKE :evt_motif OR usr_evt.usrAbsDateDebut LIKE :evt_date_debut
             OR usr_evt.usrAbsDateFin LIKE :evt_date_fin 
             OR usr_evt.usrAbsPj LIKE :evt_pj OR usr_evt.usrAbsRemarque LIKE :evt_remarque')
                ->setParameter('evt_usr_abs_typ', '%'.$_options['search'].'%')
                ->setParameter('usr_firstname', '%'.$_options['search'].'%')
                ->setParameter('usr_lastname', '%'.$_options['search'].'%')
                ->setParameter('evt_motif', '%'.$_options['search'].'%')
                ->setParameter('evt_date_debut', '%'.$_options['search'].'%')
                ->setParameter('evt_date_fin', '%'.$_options['search'].'%')
                ->setParameter('evt_pj', '%'.$_options['search'].'%')
                ->setParameter('evt_remarque', '%'.$_options['search'].'%');
        }

        return $_qb;
    }
    /*
     * ==========================================================
     * Fin - Pagination en mode chargement - Liste des evenements
     * ==========================================================
     */
}
