<?php

namespace App\Controller;

use App\Entity\HomeBanner;
use App\Entity\Objective;
use App\Form\ObjectiveType;
use App\Repository\HomeBannerRepository;
use App\Repository\ObjectiveRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/objective')]
class ObjectiveController extends AbstractController
{
    #[Route('/', name: 'app_objective_index', methods: ['GET'])]
    public function index(ObjectiveRepository $objectiveRepository): Response
    {
        return $this->render('objective/index.html.twig', [
            'objectives' => $objectiveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_objective_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ObjectiveRepository $objectiveRepository): Response
    {
        $objective = new Objective();
        $form = $this->createForm(ObjectiveType::class, $objective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // L'objectif par default seras desactiver
            $objective->setIsActive(false);
            $objectiveRepository->save($objective, true);

            return $this->redirectToRoute('app_objective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objective/new.html.twig', [
            'objective' => $objective,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objective_show', methods: ['GET'])]
    public function show(Objective $objective): Response
    {
        return $this->render('objective/show.html.twig', [
            'objective' => $objective,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_objective_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Objective $objective, ObjectiveRepository $objectiveRepository): Response
    {
        $form = $this->createForm(ObjectiveType::class, $objective);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $objectiveRepository->save($objective, true);

            return $this->redirectToRoute('app_objective_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('objective/edit.html.twig', [
            'objective' => $objective,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_objective_delete', methods: ['POST'])]
    public function delete(Request $request, Objective $objective, ObjectiveRepository $objectiveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$objective->getId(), $request->request->get('_token'))) {
            $objectiveRepository->remove($objective, true);
        }

        return $this->redirectToRoute('app_objective_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * Contrôleur de la route d'activation d'une section
     */
    #[Route('/admin/activation/{id}', name: 'admin_activation_objective')]
    public function activate(Objective $objective, ManagerRegistry $doctrine, ObjectiveRepository $objectiveRepository ): Response
    {

        // On vérifie s'il y a une section active
        $activeBannerImg = $objectiveRepository->findOneBy(['isActive' => true]);

        // Si la section sélectionnée est déjà active
        if ($objective->isIsActive()) {
            // On désactive la section
            $objective->setIsActive(false);
        } else {
            // Si la section sélectionnée n'est pas active
            // On vérifie s'il y a une section active
            if ($activeBannerImg) {
                // On désactive la section active
                $activeBannerImg->setIsActive(false);
                $em = $doctrine->getManager();
                $em->persist($activeBannerImg);
                $em->flush();
            }
            // On active la section sélectionnée
            $objective->setIsActive(true);
        }

        // On enregistre les modifications en base de données
        $em = $doctrine->getManager();
        $em->persist($objective);
        $em->flush();

        return new Response("true");
    }
}
