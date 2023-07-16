<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ prénom
            ->add('firstname', TextType::class, [
                'label' => 'Prénom*',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le prénom doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le prénom doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])

            // Champ nom de famille
            ->add('lastname', TextType::class, [
                'label' => 'Nom*',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'minMessage' => 'Le nom de famille doit contenir au moins {{ limit }} caractères',
                        'maxMessage' => 'Le nom de famille doit contenir au maximum {{ limit }} caractères',
                    ]),
                ],
            ])
            // Champ Email
            ->add('email', EmailType::class, [
                'label' => 'Adresse Email',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner une adresse email',
                    ]),
                    new Email([
                        'message' => 'L\'adresse email {{ value }} n\'est pas une adresse valide',
                    ]),
                ],
            ])

            // Champ mot de passe ( en double )
            ->add('plainPassword', RepeatedType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe ne correspond pas à sa confirmation',
                'first_options' => [
                    'label' => 'Mot de passe'
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe'
                ],
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères',
                        'max' => 4096,
                        'maxMessage' => 'Votre mot de passe doit contenir au maximum {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[ !"#\$%&\'()*+,\-.\/:;<=>?@[\\\\\]\^_`{\|}~]).{8,4096}$/u',
                        'message' => 'Votre mot de passe doit contenir obligatoirement une minuscule, une majuscule, un chiffre et un caractère spécial',
                    ]),
                ],
            ])
            // Bouton de validation
            ->add('save', SubmitType::class, [
                'label' => 'Créer un compte',
                'attr' => [
                    'class' => 'btn btn-outline-primary w-100',
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,

        ]);
    }
}
