<?php

namespace App\Controller;

use App\Repository\HomeBannerRepository;
use App\Repository\ObjectiveRepository;
use App\Repository\ServiceCardRepository;
use App\Repository\SessionCardRepository;
use App\Repository\TrainingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/accueil', name: 'main_index')]
    public function index(HomeBannerRepository $homeBannerRepository): Response
    {
        return $this->render('main/index.html.twig', [
            'banner' => $homeBannerRepository->findOneBy(['isActive' => true]),
        ]);
    }

    #[Route('/service', name: 'main_service')]
    public function service(ServiceCardRepository $serviceCardRepository): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/service.html.twig',[

        'card' => $serviceCardRepository->findAll(),

            ]);

    }
    #[Route('/formation', name: 'main_formation')]
    public function formation(TrainingRepository $trainingRepository, ObjectiveRepository $objectiveRepository): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/formation.html.twig',[
            'train' => $trainingRepository->findAll(),
            'objective'=> $objectiveRepository->findOneBy([
                'isActive' => true
            ]),
        ]);
    }

    #[Route('/session', name: 'main_session')]
    public function session(SessionCardRepository $sessionCardRepository ): Response
    {

        // Cette page appellera la vue templates/main/service.html.twig
        return $this->render('main/session.html.twig',[
            // On recupère tous les element actives $cardsession
            'cardsession' => $sessionCardRepository->findBy(['isActive' => true]),
        ]);
    }

}
