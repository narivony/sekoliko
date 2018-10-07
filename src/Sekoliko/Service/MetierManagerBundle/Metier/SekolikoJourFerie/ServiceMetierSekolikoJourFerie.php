<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoJourFerie;

use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class ServiceMetierSekolikoJourFerie
 * @package App\Sekoliko\Service\MetierManagerBundle\Metier\SekolikoJourFerie
 */
class ServiceMetierSekolikoJourFerie
{
    private $_entity_manager;
    private $_container;

    public function __construct(EntityManager $_entity_manager, Container $_container)
    {
        $this->_entity_manager = $_entity_manager;
        $this->_container = $_container;
    }

    /**
     * Filtre
     * @param Request $_request
     * @return array
     */
    public function getFilters($_request)
    {
        $_filters = array();
        $_start = $_request->query->get('iDisplayStart');
        $_length = $_request->query->get('iDisplayLength');

        if (isset($_start)) {
            $_filters['start'] = (int)$_start;
        }
        if (isset($_length)) {
            $_filters['length'] = (int)$_length;
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
    public function getNbSekolikoJourFerieQueryBuilder($_options = null)
    {
        $_qb = $this->findByQueryBuilder($_options);

        return $_qb->select('COUNT(DISTINCT jf.id) AS nb');

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
                $_qb->groupBy('jf.id');
                $_qb->orderBy('jf.id', 'DESC');
            } else {
                foreach ($_sortings as $_sorting_column => $_sorting_direction) {
                    $_qb->groupBy('jf.id');
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
     * Récupérer tous les jours feries
     * @param array $_options
     * @param array $_filters
     * @param array $_sortings
     * @return mixed
     */
    public function getAllSekolikoJourFerieBy($_options, $_filters = [], $_sortings = [])
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
    public function getNbSekolikoJourFerieBy($_options = [], $_filters = [])
    {
        $_query = $this->getNbSekolikoJourFerieQueryBuilder($_options);

        return $_query->getQuery()->getSingleResult();
    }

    /**
     * Filtre de recherche
     * @param array $_options
     * @return \Doctrine\ORM\QueryBuilder
     */
    public function findByQueryBuilder($_options = null)
    {
        $_jour_ferie = EntityName::Sekoliko_JOUR_FERIE;

        $_qb = $this->_entity_manager
            ->createQueryBuilder('jf')
            ->select('jf')
            ->from($_jour_ferie, 'jf');

        // Filtre recherche
        if ($_options['search'] != '') {
            if (preg_match("/^[0-9]{1,2}\/[0-9]{1,2}\/[0-9]{4}$/", $_options['search'])) {
                $_search_date = \DateTime::createFromFormat('d/m/Y', $_options['search'])->format('Y-m-d');
                $_qb->andWhere('jf.jrFerDate LIKE :jr_fer_date')
                    ->setParameter('jr_fer_date', '%' . $_search_date . '%');
            } else {
                $_qb->andWhere('jf.jrFerNom LIKE :jr_fer_nom')
                    ->setParameter('jr_fer_nom', '%' . $_options['search'] . '%');
            }
        }

        return $_qb;
    }
}