<?php

namespace App\Form;

use App\Entity\Categorie;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Désignation',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoir',
                    ])
                ]
            ])
            ->add('description', CKEditorType::class, [
                'required' => false,
            ])
            ->add('hexColor', ColorType::class, [
                'label' => 'Couleur hexadecimal',
                'attr' => ['class'=>'p-1'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est obligatoir',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Categorie::class,
        ]);
    }
}
