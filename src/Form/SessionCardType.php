<?php

namespace App\Form;

use App\Entity\SessionCard;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class SessionCardType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le titre',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 80,
                        'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères',
                        'minMessage' => 'Le titre doit contenir au minimum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('content', TextType::class, [
                'label' => 'Paragraphe',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner le paragraphe',
                    ]),
                    new Length([
                        'min' => 2,
                        'max' => 255,
                        'maxMessage' => 'Le paragraphe doit contenir au maximum {{ limit }} caractères',
                        'minMessage' => 'Le paragraphe doit contenir au minimum {{ limit }} caractères',
                    ])
                ]
            ])
            ->add('titleColor', ColorType::class, [
                'label' => 'Titre Couleur',
                'attr' => [
                    'class' => 'form-control-color',
                ]
            ])
            ->add('contentColor', ColorType::class, [
                'label' => 'Paragraphe Couleur'
            ])

        ->add('startDate', DateType::class, [
        'label' => 'Date de début de formation',
        'widget' => 'single_text',

    ])

            ->add('endDate', DateType::class, [
                'label' => 'Date de fin de formation',
                'widget' => 'single_text',

            ])
            ->add('price',MoneyType::class,[
                'label'=> 'Le prix de la formation',

                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SessionCard::class,
        ]);
    }
}
