<?php

namespace App\Form;

use App\Entity\Commande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CommandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('montant', HiddenType::class)
        ->add('reservationDate', DateType::class, [
            'label' => 'Date de la reservation',
            'attr' => [
                'class' => "js-datepicker",
            ],
            'widget' => 'single_text','constraints' => [
                new NotBlank()
            ],
        ])
        ->add('reservationStartAt', TimeType::class, [
            'widget' => 'single_text',
            'attr' => ['class' => ''],
            'constraints' => [
                new NotBlank([
                    'message' => 'Champ obligatoire!',
                ]),
            ]
        ])
        ->add('reservationEndAt', TimeType::class, [
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
            'data_class' => Commande::class,
        ]);
    }
}
