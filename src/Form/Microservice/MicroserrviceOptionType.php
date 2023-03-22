<?php

namespace App\Form\Microservice;

use App\Entity\Microservice;
use App\Form\ServiceOptionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MicroserrviceOptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('promo', CheckboxType::class, [
                'label' => 'En promootion',
                'help' => "Cocher pour mettre se service en promotion",
                'required' => false
            ])
            ->add('serviceOptions', CollectionType::class, [
                'entry_type' => ServiceOptionType::class,
                'label' => false,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Microservice::class,
        ]);
    }
}
