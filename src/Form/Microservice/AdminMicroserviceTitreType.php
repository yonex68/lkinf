<?php

namespace App\Form\Microservice;

use App\Entity\Categorie;
use App\Entity\Microservice;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class AdminMicroserviceTitreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => false,
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'font-weight-bold text-muted', 'placeholder' => 'Titre'],
            ])
            ->add('categorie', EntityType::class, [
                'label'     =>  false,
                //'multiple'     =>  true,
                'attr' => ['class' => ""],
                'placeholder'     =>  '--Sélectionnez une catégorie--',
                'class' => Categorie::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ])
                ],
            ])
            ->add('vendeur', EntityType::class, [
                'help' => "A qui appartient ce service?",
                'class' => User::class,
                'expanded' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Microservice::class,
        ]);
    }
}
