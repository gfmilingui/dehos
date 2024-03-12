<?php

namespace App\Form;

use App\Entity\BonSortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class BonSortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'label' => 'Référence',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la référence",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
                'disabled' => true,
            ])
            ->add('date_sortie', DateTimeType::class, [
                'label' => 'Date Sortie',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la date de sortie",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
                'required' => false,
            ])
            ->add('nom_fourgon_chauffeur', TextType::class, [
                'label' => 'Nom fourgon (chauffeur)',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir le nom fourgon (chauffeur)",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false
            ])
            ->add('remarque', TextareaType::class, [
                'label' => 'Remarques',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-8'],
                'attr' => [
                    'placeholder'=> "Saisir les remarques",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BonSortie::class,
        ]);
    }
}
