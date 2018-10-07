<?php

namespace App\Sekoliko\BackOffice\AdminBundle\Controller;

use App\Sekoliko\Service\MetierManagerBundle\Form\SekolikoRoleType;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use App\Sekoliko\Service\MetierManagerBundle\Entity\SekolikoRole;

/**
 * Class SekolikoRoleController
 */
class SekolikoRoleController extends Controller
{
    /**
     * Afficher tout les rôles
     * @return Render page
     */
    public function indexAction()
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        // Récupérer tout les role
        $_roles = $_utils_manager->getAllEntities(EntityName::Sekoliko_USER_ROLE);

        return $this->render('AdminBundle:SekolikoRole:index.html.twig', array(
            'roles' => $_roles,
        ));
    }

    /**
     * Affichage page modification rôle
     * @param SekolikoRole $_role
     * @return Render page
     */
    public function editAction(SekolikoRole $_role)
    {
        if (!$_role) {
            throw $this->createNotFoundException('Unable to find SekolikoRole entity.');
        }

        $_edit_form = $this->createEditForm($_role);

        return $this->render('AdminBundle:SekolikoRole:edit.html.twig', array(
            'role'      => $_role,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création rôle
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_role = new SekolikoRole();
        $_form = $this->createCreateForm($_role);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement rôle
            $_utils_manager->saveEntity($_role, 'new');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.ajout');

            $_utils_manager->setFlash('success', $_flash_message );

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:SekolikoRole:add.html.twig', array(
            'role' => $_role,
            'form' => $_form->createView(),
        ));
    }

    /**
     * Modification rôle
     * @param Request $_request requête
     * @param SekolikoRole $_role
     * @return Render page
     */
    public function updateAction(Request $_request, SekolikoRole $_role)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        if (!$_role) {
            throw $this->createNotFoundException('Unable to find SekolikoRole entity.');
        }

        $_edit_form = $this->createEditForm($_role);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            $_utils_manager->saveEntity($_role, 'update');

            $_flash_message = $this->get('translator')->trans('bo.confirmation.modification');

            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('role_index'));
        }

        return $this->render('AdminBundle:SekolikoRole:edit.html.twig', array(
            'role'      => $_role,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création formulaire d'édition rôle
     * @param SekolikoRole $_role The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(SekolikoRole $_role)
    {
        $_form = $this->createForm(SekolikoRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_new'),
            'method' => 'POST'
        ));

        return $_form;
    }

    /**
     * Création formulaire de création rôle
     * @param SekolikoRole $_role The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(SekolikoRole $_role)
    {
        $_form = $this->createForm(SekolikoRoleType::class, $_role, array(
            'action' => $this->generateUrl('role_update', array('id' => $_role->getId())),
            'method' => 'PUT'
        ));

        return $_form;
    }

    /**
     * Suppression rôle
     * @param Request $_request requête
     * @param SekolikoRole $_role
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, SekolikoRole $_role)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);

        $_form = $this->createDeleteForm($_role);
        $_form->handleRequest($_request);

        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {
            // Suppression rôle
            $_utils_manager->deleteEntity($_role);

            $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');

            $_utils_manager->setFlash('success', $_flash_message);
        }

        return $this->redirectToRoute('role_index');
    }

    /**
     * Création formulaire de suppression rôle
     * @param SekolikoRole $_role The SekolikoRole entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(SekolikoRole $_role)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('role_delete', array('id' => $_role->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste rôle
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

                return $this->redirect($this->generateUrl('role_index'));
            }
            $_utils_manager->deleteGroupEntity(EntityName::Sekoliko_USER_ROLE, $_ids);
        }

        $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');

        $_utils_manager->setFlash('success', $_flash_message);

        return $this->redirect($this->generateUrl('role_index'));
    }
}