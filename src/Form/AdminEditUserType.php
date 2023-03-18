<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class AdminEditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('nom', TextType::class, [
            'label' => 'Nom*',
            'attr' => ['placeholder' => 'Nom'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
            ],
        ])->add('prenom', TextType::class, [
            'label' => 'Prénom*',
            'attr' => ['placeholder' => 'Prénom'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
            ],
        ])
        ->add('genre', ChoiceType::class, [
            'label' => 'Genre',
            'choices'  => [
                'Homme' =>  'Homme',
                'Femme'    =>  'Femme',
            ],
            'expanded' => true,
            'multiple' => false,
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
            ],
        ])
        ->add('roles', ChoiceType::class, [
            'label' => 'Rôles',
            'choices'  => [
                'Administrateur' =>  'ROLE_ADMIN',
            ],
            'expanded' => true,
            'multiple' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ ne peut pas être vide',
                ]),
            ],
        ])
        ->add('imageFile', VichImageType::class, [
            'label' => 'Avatar de compte(Png, jpg et jpeg)',
            'required'  =>  false,
            'allow_delete' =>  false,
            'download_label'     =>  false,
            'image_uri'     =>  false,
            'download_uri'     =>  false,
            'imagine_pattern'   =>  'small_size',
            'attr'   =>  ['class' => 'form-control-file'],
        ])
        ->add('email', EmailType::class, [
            'label' => 'E-mail',
            'attr' => ['placeholder' => 'Exemple@domail.com'],
            'constraints' => [
                new NotBlank([
                    'message' => 'Ce champ est requis',
                ]),
                new Email([
                    'message' => 'Veuillez saisir une adresse email valide',
                ]),
            ],
        ])
        ->add('plainPassword', PasswordType::class, [
            'label' => 'Mot de passe',
            'required' => false,
            'mapped' => false,
            'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Mot de passe'],
            'constraints' => [
                new Length([
                    'min' => 6,
                    'minMessage' => 'Votre mot de passe doit être au moins {{ limit }} caractères',
                    // max length allowed by Symfony for security reasons
                    'max' => 4096,
                ]),
            ],
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
