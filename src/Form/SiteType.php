<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Contrat;
use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\AvailableOptions;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', EntityType::class, [
                'label' => 'Client *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Choisir le client",
                    'class' => "form-select form-select-sm",
                ],
                'class' => Client::class,
                'choice_label' => 'nom',
                // 'empty_data' => null,
                // 'placeholder'=> "Choisir",
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
            ->add('nombre_bennes', NumberType::class, [
                'label' => 'Nombre de Bennes *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le Numéro de Bennes",
                    'class' => "form-control form-control-sm",
                ],
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
