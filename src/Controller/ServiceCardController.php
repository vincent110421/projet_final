<?php

namespace App\Controller;

use App\Entity\ServiceCard;
use App\Form\ServiceCardType;
use App\Repository\ServiceCardRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/service/card')]
class ServiceCardController extends AbstractController
{
    #[Route('/', name: 'app_service_card_index', methods: ['GET'])]
    public function index(ServiceCardRepository $serviceCardRepository): Response
    {
        return $this->render('service_card/index.html.twig', [
            'service_cards' => $serviceCardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServiceCardRepository $serviceCardRepository): Response
    {
        $serviceCard = new ServiceCard();
        $form = $this->createForm(ServiceCardType::class, $serviceCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCardRepository->save($serviceCard, true);

            return $this->redirectToRoute('app_service_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_card/new.html.twig', [
            'service_card' => $serviceCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_card_show', methods: ['GET'])]
    public function show(ServiceCard $serviceCard): Response
    {
        return $this->render('service_card/show.html.twig', [
            'service_card' => $serviceCard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_service_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ServiceCard $serviceCard, ServiceCardRepository $serviceCardRepository): Response
    {
        $form = $this->createForm(ServiceCardType::class, $serviceCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $serviceCardRepository->save($serviceCard, true);

            return $this->redirectToRoute('app_service_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service_card/edit.html.twig', [
            'service_card' => $serviceCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_service_card_delete', methods: ['POST'])]
    public function delete(Request $request, ServiceCard $serviceCard, ServiceCardRepository $serviceCardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$serviceCard->getId(), $request->request->get('_token'))) {
            $serviceCardRepository->remove($serviceCard, true);
        }

        return $this->redirectToRoute('app_service_card_index', [], Response::HTTP_SEE_OTHER);
    }
}
