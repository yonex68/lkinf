<?php

namespace App\Form\Microservice;

use App\Entity\Disponibilite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class DisponibiliteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('jour', ChoiceType::class, [
                'label' => 'Jour',
                'choices' => [
                    'Lundi' => 'Lundi',
                    'Mardi' => 'Mardi',
                    'Mercredi' => 'Mercredi',
                    'Jeudi' => 'Jeudi',
                    'Vendredi' => 'Vendredi',
                    'Samedi' => 'Samedi',
                    'Dimanche' => 'Dimanche'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire!',
                    ]),
                ]
            ])
            ->add('heureOuverture', TimeType::class, [
                'label' => 'A partir de',
                'widget' => 'single_text',
                'attr' => ['class' => 'w-100'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire!',
                    ]),
                ]
            ])
            ->add('heureCloture', TimeType::class, [
                'label' => 'A',
                'widget' => 'single_text',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Champ obligatoire!',
                    ]),
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Disponibilite::class,
        ]);
    }
}
