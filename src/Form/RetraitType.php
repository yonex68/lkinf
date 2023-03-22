<?php

namespace App\Form;

use App\Entity\Retrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class RetraitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant', MoneyType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peux pas être vide',
                    ]),
                ],
            ])
            ->add('nomsurCarte', TextType::class, [
                'label' => 'Nom du titulaire de la carte'
            ])
            ->add('numeroCarte', TextType::class, [
                'label' => 'Numéro de carte'
            ])
            ->add('dateExpiration', DateType::class, [
                'label' => "Date d'expiration",
                'widget' => 'single_text',
            ])
            ->add('adressePaypal', TextType::class, [
                'label' => "Adresse de paiement Paypal",
            ])
            ->add('modePaiement', ChoiceType::class, [
                'choices'  => [
                    'Paypal' => 'Paypal',
                    'Virement Bancaire' => 'Virement Bancaire',
                ],
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Retrait::class,
        ]);
    }
}
