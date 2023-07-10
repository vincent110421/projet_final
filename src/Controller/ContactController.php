<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'main_contact')]
    public function index(Request $request, ContactRepository $contactRepository, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);



        // si le formulaire a été envoyé
        if($form->isSubmitted()&& $form->isValid()){

            // Si le formulaire est valide


            // On prépare un email
            $mail = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('')
                ->replyTo($form->get('email')->getData())


                ->subject($form->get('subject')->getData())
                // Template utiliser pour l'email
                ->htmlTemplate('email/contact_receive.html.twig')
                ->context([ // Envois des éléments à notre vue
                    'firstname' => $form->get('firstname')->getData(),

                    'lastname' => $form->get('lastname')->getData(),

                    'mail' => $form->get('email')->getData(),

                    'subject' => $form->get('subject')->getData(),

                    'message' => $form->get('message')->getData(),


                ])



            ;

            // On envoie l'email
            $mailer->send($mail);

            // Message de succès
            $this->addFlash('success', 'Votre email à été envoyé avec succès, Merci de nous avoir contacter. Nous vous recontacterons dans les plus bref délais');


            /* TODO : Rediriger la route */
            // Redirection sur la page d'accueil
            $this->redirectToRoute('main_index');
        }

        return $this->render('main/contact.html.twig', [
            // Envoi du formulaire à la vue
            'form' => $form->createView(),

        ]);
    }



}

