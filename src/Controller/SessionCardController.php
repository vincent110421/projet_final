<?php

namespace App\Controller;

use App\Entity\HomeBanner;
use App\Entity\SessionCard;
use App\Form\SessionCardType;
use App\Repository\HomeBannerRepository;
use App\Repository\SessionCardRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/session/card')]
#[IsGranted('ROLE_ADMIN')]
class SessionCardController extends AbstractController
{
    #[Route('/', name: 'app_session_card_index', methods: ['GET'])]
    public function index(SessionCardRepository $sessionCardRepository): Response
    {
        return $this->render('session_card/index.html.twig', [
            'session_cards' => $sessionCardRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_session_card_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $sessionCard = new SessionCard();
        $form = $this->createForm(SessionCardType::class, $sessionCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $sessionCard->setIsActive(false);
            $em = $doctrine->getManager();
            $em->persist($sessionCard);
            $em->flush();


            $this->addFlash('success', 'Modification crée avec succès');

                return $this->redirectToRoute('app_session_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_card/new.html.twig', [
            'session_card' => $sessionCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_card_show', methods: ['GET'])]
    public function show(SessionCard $sessionCard): Response
    {
        return $this->render('session_card/show.html.twig', [
            'session_card' => $sessionCard,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_session_card_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, SessionCard $sessionCard, SessionCardRepository $sessionCardRepository, ManagerRegistry $doctrine): Response
    {
        $form = $this->createForm(SessionCardType::class, $sessionCard);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $sessionCardRepository->save($sessionCard, true);



            $this->addFlash('success', 'modifié avec succès');

            return $this->redirectToRoute('app_session_card_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('session_card/edit.html.twig', [
            'session_card' => $sessionCard,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_session_card_delete', methods: ['POST'])]
    public function delete(Request $request, SessionCard $sessionCard, SessionCardRepository $sessionCardRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sessionCard->getId(), $request->request->get('_token'))) {
            $sessionCardRepository->remove($sessionCard, true);
        }

        return $this->redirectToRoute('app_session_card_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * Contrôleur de la route d'activation d'une section
     */
    #[Route('/admin/activation/{id}', name: 'admin_activation_session_card')]
    public function activate(sessioncard $session, ManagerRegistry $doctrine): Response
    {
    // On recupère la valeur du champ isActive pour la section selectionner
      $active= $session->isIsActive();
      // Si la section n'est pas activer, alors on la activera sinon on la desactivera
      $session->setIsActive(!$active);
        $em=$doctrine->getManager();
        $em->persist($session);
        $em->flush();
        return new Response("true");
    }

}
