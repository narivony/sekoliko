<?php

namespace App\Sekoliko\Service\UserBundle\Controller;

use App\Sekoliko\Service\MetierManagerBundle\Utils\RoleName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use App\Sekoliko\Service\UserBundle\Entity\User;
use App\Sekoliko\Service\UserBundle\Form\UserType;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class UserController
 */
class UserController extends Controller
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
     * Afficher tout les utilisateurs
     * @return Render page
     */
    public function indexAction()
    {

        return $this->render('UserBundle:User:index.html.twig');
    }

    /**
     * Ajax liste user
     * @param Request $_request
     * @return Response
     */
    public function listAjaxAction(Request $_request)
    {
        // Récupérer service
        $_user_manager = $this->get(ServiceName::SRV_METIER_USER);

        // Filtre et triage
        $_filters  = $_user_manager->getFilters($_request);
        $_sortings = $_user_manager->getSortings($_request, array(
            '',
            'usr.usrFirstname',
            'usr.email',
            'usr.usrAddress',
            'usr.sekolikoRole',
            ''
        ));

        // Filtre de recherche
        $_options = array('search' => $_request->query->get('sSearch'));

        // Récupérer les enregistrements
        $_nb_paris       = $_user_manager->getNbSekolikoUsertBy($_options);
        $_product_result = $_user_manager->getAllSekolikoUsertBy($_options, $_filters, $_sortings);

        // Traitement json
        $_template = 'UserBundle:User:list.json.twig';
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
     * Affichage fiche utilisateur
     *
     * @param User $_user
     *
     * @return Render page
     */
    public function showAction(User $_user)
    {
        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('UserBundle:User:show.html.twig', array(
            'user' => $_user
        ));
    }

    /**
     * Affichage page modification utilisateur
     * @param User $_user
     * @return Response
     */
        public function editAction(User $_user)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);
        $_user_manager  = $this->get(ServiceName::SRV_METIER_USER);
        $_edit_form      = $this->createEditForm($_user);

        if (!$_user) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'user' => $_user,
            'edit_form' => $_edit_form->createView()
        ));
    }

    /**
     * Création utilisateur
     * @param Request $_request requête
     * @return Render page
     */
    public function newAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);
        $_user_manager  = $this->get(ServiceName::SRV_METIER_USER);

        $_user = new User();
        $_form = $this->createCreateForm($_user);
        $_form->handleRequest($_request);

        if ($_form->isSubmitted() && $_form->isValid()) {
            // Enregistrement utilisateur
            $_post     = $_request->request->all();
            $_new_user = $_user_manager->addUser($_user, $_form);

            $_flash_message = $this->get('translator')->trans('bo.confirmation.ajout');

            $_utils_manager->setFlash('success', $_flash_message );

            return $this->redirect($this->generateUrl('user_index'));
        }

        return $this->render('UserBundle:User:add.html.twig', array(
            'user'           => $_user,
            'form'           => $_form->createView()
        ));
    }
    /**
     * Modification utilisateur
     * @param Request $_request
     * @param User $_user
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function updateAction(Request $_request, User $_user)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);
        $_user_manager  = $this->get(ServiceName::SRV_METIER_USER);

        if (!$_user) {
            throw $this->createNotFoundException('Tsy misy io e .');
        }

        $_edit_form = $this->createEditForm($_user);
        $_edit_form->handleRequest($_request);

        if ($_edit_form->isValid()) {
            // Mise à jour utilisateur
            $_request->request->all();
            $_user_manager->updateUser($_user, $_edit_form);
            $_flash_message = $this->get('translator')->trans('bo.confirmation.modification');
            $_utils_manager->setFlash('success', $_flash_message);

            return $this->redirect($this->generateUrl('user_index'));

        }

        return $this->render('UserBundle:User:edit.html.twig', array(
            'user'           => $_user,
            'edit_form'      => $_edit_form->createView(),
        ));
    }

    /**
     * Création formulaire d'édition utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->container->get('security.token_storage')->getToken()->getUser();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('user_new'),
            'method'    => 'POST',
        ));

        return $_form;
    }

    /**
     * Création formulaire de création utilisateur
     * @param User $_user The entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(User $_user)
    {
        // Récupérer l'utilisateur connecté
        $_user_connected = $this->container->get('security.token_storage')->getToken()->getUser();

        $_form = $this->createForm(UserType::class, $_user, array(
            'action'    => $this->generateUrl('user_update', array('id' => $_user->getId())),
            'method'    => 'PUT',
        ));

        return $_form;
    }

    /**
     * Suppression utilisateur
     * @param Request $_request requête
     * @param User $_user
     * @return Redirect redirection
     */
    public function deleteAction(Request $_request, User $_user)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);
        $_user_manager  = $this->get(ServiceName::SRV_METIER_USER);
        $_form = $this->createDeleteForm($_user);
        $_form->handleRequest($_request);
        if ($_request->isMethod('GET') || ($_form->isSubmitted() && $_form->isValid())) {

            // Suppression utilisateur
            $_user_manager->deleteUser($_user);
            $_flash_message = $this->get('translator')->trans('bo.confirmation.suppression');
            $_utils_manager->setFlash('success', $_flash_message);
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Création formulaire de suppression utilisateur
     * @param User $_user The user entity
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $_user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $_user->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * Ajax suppression fichier image utilisateur
     * @param Request $_request
     * @return JsonResponse
     */
    public function deleteImageAjaxAction(Request $_request) {
        // Récupérer manager
        $_user_upload_manager = $this->get(ServiceName::SRV_METIER_USER_UPLOAD);

        // Récuperation identifiant fichier
        $_data = $_request->request->all();
        $_id   = $_data['id'];

        // Suppression fichier image
        $_response = $_user_upload_manager->deleteImageById($_id);

        return new JsonResponse($_response);
    }

    /**
     * Suppression par groupe séléctionnée
     * @param Request $_request
     * @return Redirect liste utilisateur
     */
    public function deleteGroupAction(Request $_request)
    {
        // Récupérer manager
        $_utils_manager = $this->get(ServiceName::SRV_METIER_UTILS);
        $_user_manager  = $this->get(ServiceName::SRV_METIER_USER);

        if ($_request->request->get('_group_delete') !== null) {
            $_ids = $_request->request->get('delete');
            if ($_ids == null) {
                $_selectionned_message = $this->get('translator')->trans('bo.confirmation.selection.suppression');
                $_utils_manager->setFlash('error', $_selectionned_message);

                return $this->redirect($this->generateUrl('user_index'));
            }

            $_user_manager->deleteGroupUser($_ids);
        }

        return $this->redirect($this->generateUrl('user_index'));
    }
}