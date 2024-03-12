<?php

namespace App\Form;

use App\Entity\ClientCategorie;
use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\AvailableOptions;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('clientCategorie', EntityType::class, [
                'label' => 'Catégorie *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Choisir la catégorie",
                    'class' => "form-select form-select-sm",
                ],
                'class' => ClientCategorie::class,
                'choice_label' => 'nom',
                // 'empty_data' => null,
                'placeholder'=> "Choisir le catégorie",
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le nom",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('raison_sociale', TextType::class, [
                'label' => 'Raison sociale *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir la Raison sociale",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('numero_identification_sociale', TextType::class, [
                'label' => 'Num Identification Sociale',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le Numéro Identification Sociale",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('nombre_lits', NumberType::class, [
                'label' => 'Nombre de lit',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le nombre de lit",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('num_tel', TextType::class, [
                'label' => 'Numéro Téléphone *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le Numéro Tél",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('fax', TextType::class, [
                'label' => 'Numéro Fax',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir la Fax",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('quartier', TextType::class, [
                'label' => 'Quartier *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le quartier",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir l'adresse",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('ville', TextType::class, [
                'label' => 'Ville *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir la ville",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('code_postal', TextType::class, [
                'label' => 'Code postal',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le code postal",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('pays', ChoiceType::class, [
                'label' => 'Pays *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Choisir le pays",
                    'class' => "form-select form-select-sm",
                ],
                'choices'  =>AvailableOptions::getPays()
            ])
            ->add('site_web', TextType::class, [
                'label' => 'Site web',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le site web",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('internet', TextType::class, [
                'label' => 'Internet',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Internet",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
