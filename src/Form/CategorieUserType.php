<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class CategorieUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lieuPrestation', TextType::class, [
                'label' => 'Lieu de prestation',
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ]),
                ],
                'attr' => ['class' => 'font-weight-bold text-muted', 'placeholder' => 'Lieu de prestation'],
            ])
            ->add('homeStudio', CheckboxType::class, [
                'label'     =>  'Home studio',
                'help'     =>  "Cocher uniquement s'il s'agit d'un Home studio",
            ])
            ->add('categorie', EntityType::class, [
                'label'     =>  'Catégorie de prestataire',
                'expanded'     =>  true,
                'attr' => ['class' => ""],
                'placeholder'     =>  '--Catégorie de prestataire--',
                'class' => Categorie::class,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ est requis',
                    ])
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
