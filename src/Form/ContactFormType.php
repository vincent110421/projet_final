<?php

namespace App\Form;

use App\Entity\Contact;
use App\Recaptcha\RecaptchaValidator;
use ReCaptcha\ReCaptcha;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner une adresse email',
                    ]),
                    new Email([
                        'message'=> 'L\'adresse email {{ value }} n\'est pas une adresse valide',
                    ]),
                ],
            ])

            ->add('name',TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner votre nom',
                    ]),
                    new Length([

                            'min' => 2,
                            'max' => 50,
                            'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères. ',
                            'maxMessage' => 'Le nom doit contenir au maximum {{ limit }} caractères ',

                    ]),
                ],
            ])

            ->add('firstname', TextType::class, [
        'label' => 'Prénom',
        'constraints' => [
            new NotBlank([
                'message' => 'Merci de renseigner votre Prénom',
            ]),
            new Length([

                'min' => 2,
                'max' => 50,
                'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères. ',
                'maxMessage' => 'Le prénom doit contenir au maximum {{ limit }} caractères ',

            ]),
        ],
    ])

            ->add('subject',TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner votre sujet',
                    ]),
                    new Length([

                        'min' => 2,
                        'max' => 100,
                        'minMessage' => 'Le sujet doit contenir au moins {{ limit }} caractères. ',
                        'maxMessage' => 'Le sujet doit contenir au maximum {{ limit }} caractères ',

                    ]),
                ],
            ])
            ->add('message',TextareaType::class, [
                'label' => 'Message',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner votre message',
                    ]),
                    new Length([

                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le message doit contenir au moins {{ limit }} caractères. ',
                        'maxMessage' => 'Le message doit contenir au maximum {{ limit }} caractères ',

                    ]),
                ],
            ])
            // Bouton de validation
            ->add('save', SubmitType::class,[
                'label'=> 'Créer un compte',
                'attr' => [
                    'class'=> 'btn btn-outline-primary w-100',
                    ]
                    ])
//        ->add('captcha', RecaptchaValidator::class, [
//            'constraints' => new Recaptcha ([
//                'message' => '',
//                'messageMissingValue' => '',
////
//            ]),
//             ])





             ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
