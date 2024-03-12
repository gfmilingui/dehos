<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Site;
use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\AvailableOptions;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DemandeType extends AbstractType
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
                'required' => true,
                // 'empty_data' => null,
                'placeholder'=> "Choisir",
            ])
            ->add('site', EntityType::class, [
                'label' => 'Site *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Choisir le site",
                    'class' => "form-select form-select-sm",
                ],
                'class' => Site::class,
                'choice_label' => 'nom',
                'required' => true,
                // 'empty_data' => null,
                'placeholder'=> "Choisir",
            ])
            ->add('nombre_bennes', NumberType::class, [
                'label' => 'Nombre de Bennes *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le Numéro de Bennes",
                    'class' => "form-control form-control-sm",
                ],
                'required' => true,
            ])
            ->add('date', DateTimeType::class, [
                'label' => 'Date',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir la date",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
