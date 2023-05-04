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
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;

class IngenieurSonType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('prix', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                    ])
                ],
                'attr' => ['class' => 'border-0 text-right']
            ])
            ->add('prixMastering', NumberType::class, [
                'label' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-right']
            ])
            ->add('prixMixage', NumberType::class, [
                'label' => "Mixage",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-right']
            ])
            ->add('prixBeatmaking', NumberType::class, [
                'label' => 'Beatmaking',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-right']
            ])
            ->add('prixComposition', NumberType::class, [
                'label' => 'Composition',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'border-0 text-right']
            ])
            ->add('description', CKEditorType::class, [
                'label' => false,
                'required' => false,
                'attr' => ['rows' => 8, 'class' => 'font-weight-bold text-muted', 'placeholder' => 'Description'], 'constraints' => [
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
