<?php

namespace App\Sekoliko\BackOffice\AdminBundle\Controller;

use App\Sekoliko\Service\MetierManagerBundle\Utils\EntityName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\ServiceName;
use App\Sekoliko\Service\MetierManagerBundle\Utils\TacheStatusName;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SekolikoDashboardController
 */
class SekolikoDashboardController extends Controller
{
    /**
     * Afficher le tableau de bord
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {


        return $this->render('AdminBundle:SekolikoDashboard:index.html.twig',[
            'dashboard'            => "Hello",
        ]);
    }
}
