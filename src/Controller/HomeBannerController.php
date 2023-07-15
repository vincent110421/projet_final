<?php

namespace App\Controller;

use App\Entity\HomeBanner;
use App\Form\HomeBannerType;
use App\Repository\HomeBannerRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use function PHPUnit\Framework\fileExists;

#[Route('/home/banner')]
#[IsGranted('ROLE_ADMIN')]
class HomeBannerController extends AbstractController
{
    #[Route('/', name: 'app_home_banner_index', methods: ['GET'])]
    public function index(HomeBannerRepository $homeBannerRepository): Response
    {
        return $this->render('home_banner/index.html.twig', [
            'home_banners' => $homeBannerRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_home_banner_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        $homeBanner = new HomeBanner();
        $form = $this->createForm(HomeBannerType::class, $homeBanner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $banner = $form->get('banner')->getData();
            if($banner){
                do{
                    $newFileName = md5(random_bytes(100)). '.' . $banner->guessExtension();
                } while(file_exists($this->getParameter('app.homebanner.photo.directory'). $newFileName));
                $homeBanner->setBanner($newFileName);
            }
            $homeBanner->setIsActive(false);
            $em = $doctrine->getManager();
            $em->persist($homeBanner);
            $em->flush();

            if($banner){
                $banner->move(
                    $this->getParameter('app.homebanner.photo.directory'),
                    $newFileName
                );


            }

            $this->addFlash('success', 'Bannière crée avec succès');

            return $this->redirectToRoute('app_home_banner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_banner/new.html.twig', [
            'home_banner' => $homeBanner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_home_banner_show', methods: ['GET'])]
    public function show(HomeBanner $homeBanner): Response
    {
        return $this->render('home_banner/show.html.twig', [
            'home_banner' => $homeBanner,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_home_banner_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HomeBanner $homeBanner,ManagerRegistry $doctrine ): Response
    {
        $form = $this->createForm(HomeBannerType::class, $homeBanner);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $banner = $form->get('banner')->getData();
            if($banner){
                do{
                    $newFileName = md5(random_bytes(100)). '.' . $banner->guessExtension();
                } while(file_exists($this->getParameter('app.homebanner.photo.directory'). $newFileName));
                $homeBanner->setBanner($newFileName);
            }
            $em = $doctrine->getManager();
            $em->persist($homeBanner);
            $em->flush();

            if($banner){
                $banner->move(
                    $this->getParameter('app.homebanner.photo.directory'),
                    $newFileName
                );


            }

            $this->addFlash('success', 'Bannière modifié avec succès');

            return $this->redirectToRoute('app_home_banner_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('home_banner/edit.html.twig', [
            'home_banner' => $homeBanner,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_home_banner_delete', methods: ['POST'])]
    public function delete(Request $request, HomeBanner $homeBanner, HomeBannerRepository $homeBannerRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$homeBanner->getId(), $request->request->get('_token'))) {
            $homeBannerRepository->remove($homeBanner, true);
        }


        return $this->redirectToRoute('app_home_banner_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * Contrôleur de la route d'activation d'une section
     */
    #[Route('/admin/activation/{id}', name: 'admin_activation_contact_img')]
    public function activate(HomeBanner $banner, ManagerRegistry $doctrine, HomeBannerRepository $homeBannerRepository): Response
    {

        // On vérifie s'il y a une section active
        $activeBannerImg = $homeBannerRepository->findOneBy(['isActive' => true]);

        // Si la section sélectionnée est déjà active
        if ($banner->isIsActive()) {
            // On désactive la section
            $banner->setIsActive(false);
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
            $banner->setIsActive(true);
        }

        // On enregistre les modifications en base de données
        $em = $doctrine->getManager();
        $em->persist($banner);
        $em->flush();

        return new Response("true");
    }

}
