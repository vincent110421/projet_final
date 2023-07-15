<?php

namespace App\Form;

use App\Entity\HomeBanner;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class HomeBannerType extends AbstractType
{
    private $allowedMimeTypes;

    public function __construct(ParameterBagInterface $params)
    {
        $this->allowedMimeTypes = $params->get('app.picture.allowed_mime_types');
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            // Image de la bannière
            ->add('banner', FileType::class, [
                'label' => 'Bannière',
                'attr' => [
                    'accept' => implode(', ', $this->allowedMimeTypes),
                ],
                'mapped' => false,
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '12M',  // Taille maximum du fichier
                        'maxSizeMessage' => 'Fichier trop volumineux ({{ size }} {{ suffix }}). La taille maximum autorisée est de {{ limit }} {{ suffix }}',
                        'mimeTypes' => $this->allowedMimeTypes,    // Types de fichiers autorisés

                        'mimeTypesMessage' => 'L\'image doit être de type jpg | png | jpeg ou webp.',
                    ]),
                ]

            ])
            
            ->add('title', TextType::class,[
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

            ->add('content', TextType::class,[
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

            ->add('titleColor', ColorType::class,[
                'label' => 'Titre Couleur',
                'attr' => [
                    'class' => 'form-control-color',
                ]
            ])

            ->add('contentColor', ColorType::class,[
                'label' => 'Paragraphe Couleur'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => HomeBanner::class,
        ]);
    }
}
