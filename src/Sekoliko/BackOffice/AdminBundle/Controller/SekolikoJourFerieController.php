<?php

namespace App\Sekoliko\BackOffice\AdminBundle\Controller;

use App\Sekoliko\Service\MetierManagerBundle\Form\SekolikoJourFerieType;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoJourFerie;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SekolikoJourFerieController
 */
class SekolikoJourFerieController extends Controller
{
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
     * Ajax liste jour ferie
     * @param \Symfony\Component\HttpFoundation\Request $_request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function listAjaxAction(Request $_request)
    {
        // Récupérer service
        $_jour_ferie_manager = $this->get(ServiceName::SRV_METIER_JOUR_FERIE);

        // Filtre et triage
        $_filters  = $_jour_ferie_manager->getFilters($_request);
        $_sortings = $_jour_ferie_manager->getSortings($_request, array(
            '',
            'jf.jrFerNom',
            'jf.jrFerDate',
            ''
        ));

        // Filtre de recherche
        $_options = array('search' => $_request->query->get('sSearch'));

        // Récupérer les enregistrements
        $_nb_paris       = $_jour_ferie_manager->getNbSekolikoJourFerieBy($_options);
        $_product_result = $_jour_ferie_manager->getAllSekolikoJourFerieBy($_options, $_filters, $_sortings);

        // Traitement json
        $_template = 'AdminBundle:SekolikoJourFerie:list.json.twig';
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
     * Afficher tous les jours feriés
     * @return Render page
     */
    public function indexAction()
    {
        return $this->render('AdminBundle:SekolikoJourFerie:index.html.twig');
    }

    /**
     * Affichage page modification Jour ferié
     * @param SekolikoJourFerie $_jour_ferie
     * @return Render page
     */
    public function editAction(SekolikoJourFerie $_jour_ferie)
    {
        if (!$_jour_ferie) {
            throw $this->createNotFoundException('Unable to find SekolikoJourFerie entity.');
        }

        $_edit_form = $this->createEditForm($_jour_ferie);

        return $this->render('AdminBundle:SekolikoJourFerie:edit.html.twig', array(
        'jour_feries' => $_jour_ferie,
        'edit_form'   => $_edit_form->createView()
        ));
    }

    /**
     * Création jour ferié
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_jour_ferie = new SekolikoJourFerie();
        $_form       = $this->createCreateForm($_jour_ferie);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement Jour ferié
            $_utils_manager->saveEntity($_jour_ferie, 'new');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.ajout');
            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('jour_ferie_index'));
        }

        return $this->render('AdminBundle:SekolikoJourFerie:add.html.twig', array(
            'jour_feries' => $_jour_ferie,
            'form'        => $_form->createView(),
        ));
    }

    /**
     * Modification jour ferié
     * @param Request $_request requête
     * @param SekolikoJourFerie $_jour_ferie
     * @return Render page
     */
    public function updateAction(Request $_request, SekolikoJourFerie $_jour_ferie)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        if (!$_jour_ferie) {
            throw $this->createNotFoundException('Unable to find SekolikoJourFerie entity.');
        }

        $_edit_form = $this->createEditForm($_jour_ferie);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_utils_manager->saveEntity($_jour_ferie, 'update');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.modification');
            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('jour_ferie_index'));
        }

        return $this->render('AdminBundle:SekolikoJourFerie:edit.html.twig', array(
            'jour_feries' => $_jour_ferie,
            'edit_form'   => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition jour ferié
     * @param SekolikoJourFerie $_jour_ferie The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SekolikoJourFerie $_jour_ferie)
    {
        $_form = $this->createForm(SekolikoJourFerieType::class, $_jour_ferie, array(
            'action' => $this->generateUrl('jour_ferie_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création jour ferié
     * @param SekolikoJourFerie $_jour_ferie The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SekolikoJourFerie $_jour_ferie)
    {
        $_form = $this->createForm(SekolikoJourFerieType::class, $_jour_ferie, array(
            'action' => $this->generateUrl('jour_ferie_update', array('id' => $_jour_ferie->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression jour ferié
     * @param Request $_request requête
     * @param SekolikoJourFerie $_jour_ferie
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, SekolikoJourFerie $_jour_ferie)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_form = $this->createDeleteForm($_jour_ferie);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression Jour ferié
            $_utils_manager->deleteEntity($_jour_ferie);

            $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');
            $_utils_manager->setFlash('success', $_flash_message);
        }

        return $this->redirectToRoute('jour_ferie_index');
    }

    /**
     * Création formulaire de suppression Jour ferié
     * @param SekolikoJourFerie $_jour_ferie The SekolikoJourFerie entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SekolikoJourFerie $_jour_ferie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('jour_ferie_delete', array('id' => $_jour_ferie->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste Jour ferié
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

                return $this->redirect($this->generateUrl('jour_ferie_index'));
            }
            $_utils_manager->deleteGroupEntity(EntityName::Sekoliko_JOUR_FERIE, $_ids);
        }

        $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');

        $_utils_manager->setFlash('success', $_flash_message);

        return $this->redirect($this->generateUrl('jour_ferie_index'));
    }
}