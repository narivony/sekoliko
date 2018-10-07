<?php

namespace App\Sekoliko\BackOffice\AdminBundle\Controller;

use App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoHoraire;
use App\Sekoliko\Service\MetierManagerBundle\Form\SekolikoHoraireType;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\UserBundle\Entity\User;
use App\Sekoliko\Service\UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SekolikoHoraireController
 * @package App\Sekoliko\BackOffice\AdminBundle\Controller
 */
class SekolikoHoraireController extends Controller
{
    /*
    * Début - Pagination en mode chargement
    */
    /**
     * Récupération données Json
     * @param Request $_request
     * @param int $_nb_total
     * @param int $_nb_displayed
     * @param mixed $_values
     * @param string $_template
     * @return string
     */
    public function getDataJson($_request, $_nb_total, $_nb_displayed, $_values, $_template)
    {
        $_data['sEcho']                = $_request->query->get('sEcho');
        $_data['iTotalRecords']        = (int) $_nb_total;
        $_data['iTotalDisplayRecords'] = (int) $_nb_displayed;

        return $this->renderView($_template, array(
            'data'   => $_data,
            'values' => $_values
        ));
    }

    /**
     * Ajax liste additionnel utilisateurs
     * @param \Symfony\Component\HttpFoundation\Request $_request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAjaxAction(Request $_request)
    {
        // Récupérer service
        $_horaire_manager = $this->get(ServiceName::SRV_METIER_HORAIRE);

        // Filtre et triage
        $_filters  = $_horaire_manager->getFilters($_request);
        $_sortings = $_horaire_manager->getSortings($_request, array(
            '',
            'hr.hrDateDebutSaison',
            'hr.hrDateFinSaison',
            'hr.hrDebut',
            'hr.hrFin',
            'hr.getHrDuree',
            ''
        ));

        // Filtre de recherche
        $_options = array('search' => $_request->query->get('sSearch'));

        // Récupérer les espaces
        $_nb_paris       = $_horaire_manager->getNbSekolikoHoraireBy($_options);
        $_product_result = $_horaire_manager->getAllSekolikoHoraireBy($_options, $_filters, $_sortings);

        // Traitement json
        $_template = 'AdminBundle:SekolikoHoraire:list.json.twig';
        $_content  = $this->getDataJson(
            $_request,
            $_nb_paris['nb'],
            $_nb_paris['nb'],
            $_product_result,
            $_template
        );
        $_response = new Response($_content);
        $_response->headers->set('Content-Type', 'application/json');

        return $_response;
    }

    /**
     * Afficher tout les horaire de traivail
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        // Récuperer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        // Récuperer tout les post
        $_horaires = $_utils_manager->getAllEntities(EntityName::Sekoliko_HORAIRE);

        return $this->render('AdminBundle:SekolikoHoraire:index.html.twig', array(
            'horaires' => $_horaires,
        ));
    }

    /**
     * Création horaire de travail
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_horaire = new SekolikoHoraire();
        $_form    = $this->createCreateForm($_horaire);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement horaire de travail
            $_utils_manager->saveEntity($_horaire, 'new');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.ajout');
            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('horaire_index'));
        }

        return $this->render('AdminBundle:SekolikoHoraire:add.html.twig', array(
            'horaire' => $_horaire,
            'form'   => $_form->createView(),
        ));
    }

    /**
     * Création formulaire d edition projetType
     * @param SekolikoHoraire $_horaire The entity
     * @return \Symfony\Component\Form\Form The form
     */
    public function createCreateForm(SekolikoHoraire $_horaire)
    {
        $_form = $this->createForm(SekolikoHoraireType::class,$_horaire,array(
            'action' => $this->generateUrl('horaire_new'),
            'method' => 'POST',
        ));

        return $_form;
    }
    /**
     * Création formulaire d'édition utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateUserForm(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->container->get('security.token_storage')->getToken()->getUser();
        $_user_role      = $_user_connected->getSekolikoRole()->getId();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('horaire_new'),
            'method'    => 'POST',
            'user_role' => $_user_role
        ));

        return $_form;
    }


    /**
     * @param SekolikoHoraire $_horaire
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function editAction(SekolikoHoraire $_horaire)
    {
        if (!$_horaire){
            throw $this->createNotFoundException('Projet introuvable');
        }

        $_edit_form = $this->createEditForm($_horaire);

        return $this->render('AdminBundle:SekolikoHoraire:edit.html.twig',array(
            'horaire' => $_horaire,
            'edit_form'  => $_edit_form->createView(),
        ));
    }

    /**
     * Création editForm
     * @param SekolikoHoraire $_horaire
     * @return \Symfony\Component\Form\FormInterface
     */
    public function createEditForm(SekolikoHoraire $_horaire)
    {
        $_form = $this-> createForm(SekolikoHoraireType::class,$_horaire,array(
            'action'  => $this->generateUrl('horaire_update',array('id'=> $_horaire->getId())),
            'method' => 'PUT',
        ));

        return $_form;
    }


    /**
     * Modification horaire
     * @param Request $_request
     * @param SekolikoHoraire $_horaire
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function updateAction(Request $_request, SekolikoHoraire $_horaire)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        if (!$_horaire) {
            throw $this->createNotFoundException('Unable to find SekolikoHoraire entity.');
        }

        $_edit_form = $this->createEditForm($_horaire);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Enregistrement post
            $_utils_manager->saveEntity($_horaire, 'update');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.modification');

            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('horaire_index'));
        }

        return $this->render('AdminBundle:SekolikoHoraire:edit.html.twig', array(
            'horaire' => $_horaire,
            'edit_form'  => $_edit_form->createView()
        ));
    }

    /**
     * Suppression
     * @param Request $_request
     * @param SekolikoHoraire $_horaire
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteAction(Request $_request, SekolikoHoraire $_horaire)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_form = $this->createDeleteForm($_horaire);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression post
            $_utils_manager->deleteEntity($_horaire);

            $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');
            $_utils_manager->setFlash('success', $_flash_message);
        }

        return $this->redirectToRoute('horaire_index');
    }


    /**
     * Création formulaire de suppression post
     * @param SekolikoHoraire $_horaire
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(SekolikoHoraire $_horaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('horaire_delete', array('id' => $_horaire->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe selectionnee
     * @param Request $_request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_selectionned_message = $this->get('translator')->trans('bo.confirmation.selection.suppression');
                $_utils_manager->setFlash('error', $_selectionned_message);

                return $this->redirect($this->generateUrl('horaire_index'));
            }
            $_utils_manager->deleteGroupEntity(EntityName::Sekoliko_HORAIRE, $_ids);
        }

        $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');

        $_utils_manager->setFlash('success', $_flash_message);

        return $this->redirect($this->generateUrl('horaire_index'));
    }
}
