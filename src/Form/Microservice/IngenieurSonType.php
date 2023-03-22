<?php

namespace App\Form\Microservice;

use App\Entity\Microservice;
use App\Form\PrixType;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class IngenieurSonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prixMastering', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-center font-weight-bold']
            ])
            ->add('prixMixage', NumberType::class, [
                'label' => "Mixage",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-center font-weight-bold']
            ])
            ->add('prixBeatmaking', NumberType::class, [
                'label' => 'Beatmaking',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-center font-weight-bold']
            ])
            ->add('prixComposition', NumberType::class, [
                'label' => 'Composition',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-center font-weight-bold']
            ])
            ->add('description', CKEditorType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['rows' => 8, 'class' => 'font-weight-bold text-muted', 'placeholder' => 'Description'], 'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
            ])->add('delai', ChoiceType::class, [
                'label' => false,
                'placeholder' => 'Choisir un délai de livraison',
                'empty_data' => 'Aucun',
                'choices'  => [
                    '1 jour' =>  1,
                    '2 jours' =>  2,
                    '3 jours' =>  3,
                    '4 jours' =>  4,
                    '5 jours' =>  5,
                    '6 jours' =>  6,
                    '7 jours' =>  7,
                    '8 jours' =>  8,
                    '9 jours' =>  9,
                    '10 jours' =>  10,
                    '11 jours' =>  11,
                    '12 jours' =>  12,
                    '13 jours' =>  13,
                    '14 jours' =>  14,
                    '15 jours' =>  15,
                    '16 jours' =>  16,
                    '17 jours' =>  17,
                    '18 jours' =>  18,
                    '19 jours' =>  19,
                    '20 jours' =>  20,
                    '21 jours' =>  21,
                    '22 jours' =>  22,
                    '23 jours' =>  32,
                    '24 jours' =>  24,
                    '25 jours' =>  25,
                    '26 jours' =>  26,
                    '27 jours' =>  27,
                    '28 jours' =>  28,
                    '29 jours' =>  29,
                    '30 jours' =>  30,
                ],
                'expanded' => false,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Microservice::class,
        ]);
    }
}
