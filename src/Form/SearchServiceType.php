<?php

namespace App\Form;

use App\Entity\Categorie;
use App\Entity\SearchService;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;

class SearchServiceType extends AbstractType
{
   public function buildForm(FormBuilderInterface $builder, array $options): void
   {
      $builder
         ->add('q', TextType::class, [
            'label' =>  false,
            'required'  =>  false,
            'attr'  =>  [
               'placeholder'   =>  'De quoi avez-vous besoin ?', 'class' =>  'w-100 shadow-none'
            ]
         ])
         ->add('jour', ChoiceType::class, [
             'label' => 'Jours',
             'expanded' => true,
             'placeholder' => 'Tout',
             'required' => false,   
             'choices' => [
                 'Lundi' => 'Lundi',
                 'Mardi' => 'Mardi',
                 'Mercredi' => 'Mercredi',
                 'Jeudi' => 'Jeudi',
                 'Vendredi' => 'Vendredi',
                 'Samedi' => 'Samedi',
                 'Dimanche' => 'Dimanche'
             ]
         ])
         ->add('heureOuverture', TimeType::class, [
            'label' => 'Ouverte',
             'widget' => 'single_text',
             'required' => false,
         ])
         ->add('heureCloture', TimeType::class, [
            'label' => 'Fermer',
             'widget' => 'single_text',
             'required' => false,
         ])
         ->add('ville', TextType::class, [
            'label' =>  'Ville',
            'required'  =>  false,
            'attr'  =>  [
               'placeholder'   =>  'Ville', 'class' =>  'w-100 shadow-none'
            ]
         ])
         ->add('minPrice', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
               'placeholder' => 'Minimum',
            ]
         ])
         ->add('maxPrice', NumberType::class, [
            'label' => false,
            'required' => false,
            'attr' => [
               'placeholder' => 'Maximum',
            ]
         ])
         ->add('categories', EntityType::class, [
            'label' => false,
            'class' => Categorie::class,
            'choice_label'  => 'name',
            'placeholder' => 'Catégorie',
            //'autocomplete' => true,
            'expanded' => true,
            'required' => false,
            'multiple' => true,
         ])
         ->add('promo', CheckboxType::class, [
            'label' => 'Services en promotion',
            'required' => false,
            'attr' => [
               'class' => null,
            ]
         ]);
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
