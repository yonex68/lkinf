<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\SearchService;
use App\Repository\CategorieRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HomeServiceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('adresse', TextType::class, [
                'label' =>  false,
                'required'  =>  false,
                'mapped'  =>  false,
                'attr'  =>  [
                    'placeholder'   =>  'Votre ville',
                    'class' => 'form-control border-0 form-control-lg border-0 bg-transparent',
                ]
            ])
            ->add('ville', HiddenType::class, [
                'label' =>  false,
                'required'  =>  false,
            ])
            /*->add('categories', EntityType::class, [
                'label' => False,
                'required' => false,
                'multiple' => true,
                'placeholder' => 'Catégorie',
                'class' => Categorie::class,
                'query_builder' => function (CategorieRepository $getCategories) {
                    return $getCategories->createQueryBuilder('c')
                    ->orderBy('c.name', 'ASC');
                },
                'choice_label' => 'name',
                'attr' => [
                    'class' => '', 
                    'placeholder' => 'Catégorie'
                ]
            ])*/;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SearchService::class,
            'method' => 'GET',
            'csrf_protection' => false,
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
