<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\NotBlank;
use Vich\UploaderBundle\Form\Type\VichImageType;

class CoordonneeType extends AbstractType
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
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom*',
                'attr' => ['placeholder' => 'Prénom'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudonyme',
                'attr' => ['placeholder' => 'Pseudonyme'],
                'required' => false,
                'help' => "Un pseudonyme est un nom d'emprunt adopté par une ou plusieurs personnes pour exercer une activité sous un autre nom que celui de son identité officielle.",
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('usePseudo', CheckboxType::class, [
                'label' => 'Utilisé le pseudonyme comme votre nom public',
                'help' => "Au lieu que votre nom et pénom soit afficher sur le site, c'est votre pseudonyme  qui sera concideré comme votre nom public",
                'required' => false
            ])
            ->add('genre', ChoiceType::class, [
                'label' => 'Genre*',
                'choices'  => [
                    'Homme' =>  'Homme',
                    'Femme'    =>  'Femme',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('imageFile', VichImageType::class, [
                'label' => '(Png, jpg et jpeg)',
                'required'  =>  false,
                'allow_delete' =>  false,
                'download_label'     =>  false,
                'image_uri'     =>  false,
                'download_uri'     =>  false,
                'imagine_pattern'   =>  'small_size',
                'attr'   =>  ['class' => 'form-control-file'],
            ])
            ->add('apropos', TextareaType::class, [
                'label' => 'Biographie',
                'help' => 'Renseignements',
                'required' => false,
                'attr' => ['rows' => 6],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'help' => 'Exemple (N° Ruelle/Avenue)',
                'attr' => ['placeholder' => 'Adresse', 'autocomplete' => "address-line1"],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville',
                'help' => 'Ville de residence actuelle',
                'attr' => ['placeholder' => 'Ville de residence', 'autocomplete' => "address-level2"],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('pays', TextType::class, [
                'label' => 'Pays',
                'help' => 'Ville de residence actuelle',
                'attr' => ['placeholder' => 'Ville de residence', 'autocomplete' => "country"],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('codePostal', TextType::class, [
                'label' => 'Code postal',
                'attr' => ['placeholder' => 'Code postal'],
                //'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('etat', TextType::class, [
                'label' => 'Etat',
                'help' => 'Etat de residence actuelle',
                'attr' => ['placeholder' => 'Ville de residence', 'autocomplete' => "address-level1"],
                'required' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'help' => 'Facultatif',
                'label' => 'Téléphone',
                'required' => false,
                'attr' => ['placeholder' => 'Téléphone'],
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'help' => 'Exemple: email@domaine.com',
                'attr' => ['placeholder' => 'Exemple@domail.com'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Ce champ ne peut pas être vide',
                    ]),
                    new Email([
                        'message' => 'Veuillez saisir une adresse email valide',
                    ]),
                ],
            ])
            ->add('statut', ChoiceType::class, [
                'label' => 'Statut',
                'choices'  => [
                    'Particulier' =>  'Particulier',
                    'Auto-entreprise ou entreprise individuelle'    =>  'Auto-entreprise ou entreprise individuelle',
                    'Société (France uniquement)'    =>  'Société (France uniquement)',
                    'Société (Autres pays)'    =>  'Société (Autres pays)',
                ],
                'expanded' => true,
                'multiple' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
