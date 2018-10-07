<?php

namespace App\Sekoliko\Service\UserBundle\Manager;

use App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoUserFonction;
use App\Sekoliko\Service\UserBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\RoleName;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class UserManager
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container      = $_container;
    }


    /**
     * Recuperer l id user connected
     * @return mixed
     */
    public function getUserIdConnected()
    {
        $_user = $this->_container->get('security.token_storage')->getToken()->getUser();
        return $_user->getId();
    }

    /**
     * Récuperer tout les utilisateurs
     * @return array
     */
    public function getAllUser()
    {
        // Récupérer manager
        $_utils_manager = $this->_container->get(ServiceName::SRV_METIER_UTILS);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();

        return $_utils_manager->getAllEntitiesByOrder(EntityName::USER, array('id' => 'DESC'));
    }

    /**
     * Tester l'existence username
     * @param string $_username
     * @return boolean
     */
    public function isUsernameExist($_username)
    {
        // Récupérer manager
        $_utils_manager = $this->_container->get(ServiceName::SRV_METIER_UTILS);

        $_exist = $_utils_manager->getRepository(EntityName::USER)->findByUsername($_username);
        if ($_exist) {
            return true;
        }

        return false;
    }

    /**
     * Tester l'existence email
     * @param string $_email
     * @return boolean
     */
    public function isEmailExist($_email)
    {
        // Récupérer manager
        $_utils_manager = $this->_container->get(ServiceName::SRV_METIER_UTILS);

        $_exist = $_utils_manager->getRepository(EntityName::USER)->findByEmail($_email);
        if ($_exist) {
            return true;
        }

        return false;
    }

    /**
     * Ajouter un utilisateur
     * @param User $_user
     * @param Object $_form
     * @return Object $_new_user
     */
    public function addUser($_user, $_form)
    {
        // Récupérer manager
        $_utils_manager       = $this->_container->get(ServiceName::SRV_METIER_UTILS);
        $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Activer par défaut
        $_user->setEnabled(1);

        // Traitement du photo
        $_img_photo = $_form['usrPhoto']->getData();
        if ($_img_photo) {
            $_user_upload_manager->upload($_user, $_img_photo);
        }

        $_new_user = $_utils_manager->saveEntity($_user, 'new');

        return $_new_user;
    }

    /**
     * Modifier un utilisateur
     * @param User $_user
     * @param Object $_form
     * @return Object $_updated_user
     */
    public function updateUser($_user, $_form)
    {
        // Récupérer manager
        $_utils_manager       = $this->_container->get(ServiceName::SRV_METIER_UTILS);
        $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Traitement photo
        $_img_photo = $_form['usrPhoto']->getData();
        // S'il y a un nouveau fichier ajouté, on supprime l'ancien fichier puis on enregistre ce nouveau
        if ($_img_photo) {
            $_user_upload_manager->deleteOnlyImageById($_user->getId());
            $_user_upload_manager->upload($_user, $_img_photo);
        }

        $_user->setUsrDateUpdate(new \DateTime());

        // Mise à jour mot de passe
        $_fos_user_manager = $this->_container->get('fos_user.user_manager');
        $_fos_user_manager->updatePassword($_user);

        $_updated_user = $_utils_manager->saveEntity($_user, 'update');

        return $_updated_user;
    }

    /**
     * Supprimer un utilisateur
     * @param User $_user
     * @return boolean
     */
    public function deleteUser($_user)
    {
        // Récupérer manager
        $_utils_manager       = $this->_container->get(ServiceName::SRV_METIER_UTILS);
        $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Suppression fichier image
        $_user_upload_manager->deleteOnlyImageById($_user->getId());

        return $_utils_manager->deleteEntity($_user);
    }

    /**
     * Suppression multiple d'un utilisateur
     * @param array $_ids
     * @return boolean
     */
    public function deleteGroupUser($_ids)
    {
        // Récupérer manager
        $_utils_manager       = $this->_container->get(ServiceName::SRV_METIER_UTILS);
        $_user_upload_manager = $this->_container->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Récupérer l'utilisateur connecté
        $_user_connected = $this->_container->get('security.token_storage')->getToken()->getUser();

        if (count($_ids)) {
            foreach ($_ids as $_id) {
                // Suppression utilisateur
                $_user = $_utils_manager->getEntityById(EntityName::USER, $_id);
                    $_message = "Suppression de " . $_user->getUsrFullname() ." réussie";
                    $_utils_manager->setFlash('success',  $_message);

                    // Suppression fichier image
                    $_user_upload_manager->deleteOnlyImageById($_id);
                    $_utils_manager->deleteEntity($_user);
            }
        }

        return false;
    }

    /**
     * Activer un utilisateur
     * @param string $_email
     * @return boolean
     */
    public function enableUserByEmail($_email)
    {
        // Récupérer manager
        $_utils_manager = $this->_container->get(ServiceName::SRV_METIER_UTILS);

        $_user = $_utils_manager->getRepository(EntityName::USER)->findByEmail($_email);

        $_user[0]->setEnabled(1);

        return $_utils_manager->saveEntity($_user, 'update');
    }


    /**
     * Récupérer tout les utilisateurs
     * @param array $_options
     * @param array $_filters
     * @param array $_sortings
     * @return mixed
     */
    public function getAllSekolikoUsertBy($_options, $_filters = [], $_sortings = [])
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
                $_qb->groupBy('usr.id');
                $_qb->orderBy('usr.id', 'DESC');
            } else {
                foreach ($_sortings as $_sorting_column => $_sorting_direction) {
                    $_qb->groupBy('usr.id');
                    $_qb->addOrderBy($_sorting_column, $_sorting_direction);
                }
            }
        }

        return $_qb;
    }

    /**
     * Filtre de recherche
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder($_options = null)
    {
        $_user = EntityName::USER;

        $_qb = $this->_entity_manager
            ->createQueryBuilder('usr')
            ->select('usr')
            ->from($_user, 'usr');

        // Filtre recherche
        if (isset($_options['search'])) {
            $_qb->andWhere("usr.email LIKE :usr_email OR usr.usrAddress
                LIKE :usr_adrs or usr.usrFirstname LIKE :usr_firstname OR usr.usrLastname LIKE :usr_lastname 
                OR usr.usrPhone LIKE :usr_phone OR CONCAT(usr.usrFirstname, ' ', usr.usrLastname) LIKE :fullname")
                ->setParameter('usr_email', '%'.$_options['search'].'%')
                ->setParameter('usr_firstname', '%'.$_options['search'].'%')
                ->setParameter('usr_lastname', '%'.$_options['search'].'%')
                ->setParameter('usr_adrs', '%'.$_options['search'].'%')
                ->setParameter('fullname', '%'.$_options['search'].'%')
                ->setParameter('usr_phone', '%'.$_options['search'].'%');
        }

        return $_qb;
    }
    /*
     * Fin - Pagination en mode chargement
     */


    /**
     * Récupérer le nombre d'enregistrement service client
     * @param array $_options
     * @param array $_filters
     * @return mixed
     */
    public function getNbSekolikoUsertBy($_options = [], $_filters = [])
    {
        $_query = $this->getNbSekolikoUserQueryBuilder($_options);

        return $_query->getQuery()->getSingleResult();
    }

    /**
     * Récupérer le nombre total d'enregistrement
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function getNbSekolikoUserQueryBuilder($_options = null)
    {
        $_qb = $this->findByQueryBuilder($_options);

        return $_qb->select('COUNT(DISTINCT usr.id) AS nb');

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
}
