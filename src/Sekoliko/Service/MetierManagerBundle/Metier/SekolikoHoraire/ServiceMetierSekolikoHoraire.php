<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoHoraire;

use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServiceMetierSekolikoHoraire
 * @package App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoHoraire
 */
class ServiceMetierSekolikoHoraire
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }

    /**
     * Récuperer le repository horaire
     * @return array
     */
    public function getRepository()
    {
        return $this->_entity_manager->getRepository(EntityName::Sekoliko_HORAIRE);
    }

    /**
     * Recuperer l horraire de travaille
     * @return mixed
     */
    public function getHeureDebutEtFinTravail(){

        $_horaire = EntityName::Sekoliko_HORAIRE;

        $_dql   = "SELECT hr FROM $_horaire hr ORDER BY hr.id DESC";
        $_query = $this->_entity_manager->createQuery($_dql);

        $_horaires = $_query->getOneOrNullResult();

        $_result = [];
        if($_horaires) {
            $_result = [
                'heure_debut'=> $_horaires->getHrDebut()->format('H:s'),
                'date_debut' => $_horaires->getHrDateDebutSaison(),
                'heure_fin'  => $_horaires->getHrFin()->format('H:s'),
                'date_fin'   => $_horaires->getHrDateFinSaison(),
            ];
        }

        return $_result;
    }

    /*
     * Début - Pagination en mode chargement
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
     * Récupérer le nombre total d'enregistrement
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNbSekolikoHoraireQueryBuilder($_options = null)
    {
        $_qb = $this->findByQueryBuilder($_options);

        return $_qb->select('COUNT(DISTINCT hr.id) AS nb');

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
     * Triage des données
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
                $_qb->groupBy('hr.id');
                $_qb->orderBy('hr.id', 'DESC');
            } else {
                foreach ($_sortings as $_sorting_column => $_sorting_direction) {
                    $_qb->groupBy('hr.id');
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
     * Récupérer tout les horaires
     * @param array $_options
     * @param array $_filters
     * @param array $_sortings
     * @return mixed
     */
    public function getAllSekolikoHoraireBy($_options, $_filters = [], $_sortings = [])
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
     * Récupérer le nombre d'enregistrement service client
     * @param array $_options
     * @param array $_filters
     * @return mixed
     */
    public function getNbSekolikoHoraireBy($_options = [], $_filters = [])
    {
        $_query = $this->getNbSekolikoHoraireQueryBuilder($_options);

        return $_query->getQuery()->getSingleResult();
    }

    /**
     * Filtre de recherche
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder($_options = null)
    {
        $_horaire = EntityName::Sekoliko_HORAIRE;

        $_qb = $this->_entity_manager
            ->createQueryBuilder('hr')
            ->select('hr')
            ->from($_horaire, 'hr');

        // Filtre recherche
        if ($_options['search'] != '') {
            if (preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $_options['search'])) {
                $_search_date = \DateTime::createFromFormat('d/m/Y', $_options['search'])->format('Y-m-d');
                $_qb->andWhere('hr.hrDateDebutSaison LIKE :hr_date_debut OR hr.hrDateFinSaison LIKE :hr_date_fin')
                    ->setParameter('hr_date_debut', '%'.$_search_date.'%')
                    ->setParameter('hr_date_fin', '%'.$_search_date.'%');
            } else {
                $_qb->andWhere('hr.hrDebut LIKE :hr_debut OR hr.hrFin LIKE :hr_fin ')
                    ->setParameter('hr_debut', '%'.$_options['search'].'%')
                    ->setParameter('hr_fin', '%'.$_options['search'].'%');
            }
        }

        return $_qb;
    }
    /*
     * Fin - Pagination en mode chargement
     */
}