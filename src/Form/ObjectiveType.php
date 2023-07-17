<?php

namespace App\Form;

use App\Entity\Objective;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use FOS\CKEditorBundle\Form\Type\CKEditorType;

class ObjectiveType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                // Label du champ
                'label' => 'Titre',

                // Liste des contraintes du champ
                'constraints' => [

                    // Ne doit pas être vide
                    new NotBlank([
                        'message' => 'Merci de renseigner un nom titre' // Message d'erreur si cette contrainte n'est pas respectée
                    ]),

                    // Doit avoir une certaine taille
                    new Length([
                        'min' => 2, // Taille minimum autorisée
                        'minMessage' => 'Le titre doit contenir au moins {{ limit }} caractères',   // Message d'erreur si plus petit
                        'max' => 100,   // Taille maximum autorisée
                        'maxMessage' => 'Le titre doit contenir au maximum {{ limit }} caractères'  // Message d'erreur si plus grand
                    ]),
                ]
            ])
            ->add('content', CKEditorType::class, [

                'label' => 'Contenu',
                'purify_html' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de renseigner un contenu'
                    ]),
                    new Length([
                        'min' => 5,
                        'minMessage' => 'Le contenu doit contenir au moins {{ limit }} caractères',
                        'max' => 5000,
                        'maxMessage' => 'Le contenu doit contenir au maximum {{ limit }} caractères'
                    ]),
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Objective::class,
        ]);
    }
}
