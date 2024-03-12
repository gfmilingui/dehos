<?php

namespace App\Form;

use App\Entity\Traitement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class TraitementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_reception', DateTimeType::class, [
                'label' => 'Date de réception *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la date de réception",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
                "required" => true,
            ])
            ->add('date_mise_traitement', DateTimeType::class, [
                'label' => 'Date de mise en traitement',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la date de mise en traitement",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
                "required" => false,
            ])
            ->add('date_fin_traitement', DateTimeType::class, [
                'label' => 'Date de fin de traitement',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la date de fin de traitement",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
                "required" => false,
            ])
            ->add('expedition_nettoyage', ChoiceType::class, [
                'label' => 'Expédition nettoyage',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Choisir",
                    'class' => "form-select form-select-sm",
                ],
                'placeholder'=> "Choisir",
                'choices'  => array("Oui" => "Oui", "Non" => "Non"),
                "required" => false,
            ])
            /*->add('expedition_retour_stock', ChoiceType::class, [
                'label' => 'Expédition retour stock *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Choisir",
                    'class' => "form-select form-select-sm",
                ],
                'placeholder'=> "Choisir",
                'choices'  => array("Oui" => "Oui", "Non" => "Non"),
                "required" => false,
            ])*/
            ->add('remarques', TextareaType::class, [
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
            'data_class' => Traitement::class,
        ]);
    }
}
