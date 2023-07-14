<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/accueil', name: 'main_index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    #[Route('/service', name: 'main_service')]
    public function service(): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/service.html.twig');
    }
    #[Route('/formation', name: 'main_formation')]
    public function articles(): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/formation.html.twig');
    }

    #[Route('/session', name: 'main_session')]
    public function session(): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/session.html.twig');
    }

}
