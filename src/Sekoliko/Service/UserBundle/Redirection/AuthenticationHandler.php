<?php

namespace App\Sekoliko\Service\UserBundle\Redirection;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class AuthenticationHandler implements AuthenticationSuccessHandlerInterface
{
    private $_router;
    private $_session;

    /**
     * Constructor
     *
     * @author 	Joe Sexton <joe@webtipblog.com>
     * @param 	RouterInterface $_router
     * @param 	Session $_session
     */
    public function __construct( RouterInterface $_router, Session $_session )
    {
        $this->_router  = $_router;
        $this->_session = $_session;
    }

    /**
     * onAuthenticationSuccess
     *
     * @author 	Joe Sexton <joe@webtipblog.com>
     * @param 	Request $_request
     * @param 	TokenInterface $_token
     * @return 	Response
     */
    public function onAuthenticationSuccess(Request $_request, TokenInterface $_token)
    {
        // Get list of roles for current user
        $_url   = $this->_router->generate('dashboard_index');
        $_roles = $_token->getRoles();
        $_roles_tab = array_map(
            function ($_role) {
                return $_role->getRole();
            },
            $_roles
        );

        if (in_array('ROLE_PERSONNEL', $_roles_tab, true)) {
            $_url = $this->_router->generate('espace_personnel_index');
        }

        return new RedirectResponse($_url);
    }
}