<?php

namespace App\Controller;

use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use ReCaptcha\ReCaptcha;
use App\Recaptcha\RecaptchaValidator;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Form\FormError;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'main_contact')]
    public function index(Request $request, ContactRepository $contactRepository, MailerInterface $mailer, RecaptchaValidator $recaptcha, ): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);



        // si le formulaire a été envoyé
        if ($form->isSubmitted() ) {

            // Récupération valeur du captcha
            $captchaResponse = $request->request->get('g-recaptcha-response', null);

            // Récupération adresse IP
            $ip = $request->server->get('REMOTE_ADRR');

            // Si le captcha contient "null" ou n'est pas valide, on ajoute une erreur dans le formulaire

            if ($captchaResponse == null || !$recaptcha->verify($captchaResponse, $ip)) {
                $form->addError(new FormError('Veuillez remplir le captcha de sécurité'));
            }

            // Si le formulaire est valide
            if($form->isValid()){

            }

            // On prépare un email
            $mail = (new TemplatedEmail())
                ->from($form->get('email')->getData())
                ->to('contact@imdadtaieb.com')
                ->replyTo($form->get('email')->getData())


                ->subject($form->get('subject')->getData())
                // Template utiliser pour l'email
                ->htmlTemplate('email/contact_receive.html.twig')
                ->context([ // Envois des éléments à notre vue
                    'firstname' => $form->get('firstname')->getData(),

                    'name' => $form->get('name')->getData(),

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

