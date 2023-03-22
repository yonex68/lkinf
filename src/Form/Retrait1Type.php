<?php

namespace App\Form;

use App\Entity\Retrait;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Retrait1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('montant')
            ->add('modePaiement')
            ->add('nomsurCarte')
            ->add('numeroCarte')
            ->add('dateExpiration')
            ->add('adressePaypal')
            ->add('created')
            ->add('updated')
            ->add('vendeur')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Retrait::class,
        ]);
    }
}
