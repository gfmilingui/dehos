<?php

namespace App\Form;

use App\Entity\SuiviRetour;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class SuiviRetourType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date_retour_benne', DateTimeType::class, [
                'label' => 'Date de retour benne *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la date de retour benne",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'with_seconds' => true,
            ])
            ->add('pesee_agent', NumberType::class, [
                'label' => 'Pesée Agent (Kg)',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la Pesée Agent (Kg)",
                    'class' => "form-control form-control-sm",
                ],
                'invalid_message' => "La valeur saisie n'est pas un nombre valide.",
                "required" => false
            ])
            ->add('pesee_client', NumberType::class, [
                'label' => 'Pesée Client (Kg)',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la Pesée Client (Kg)",
                    'class' => "form-control form-control-sm",
                ],
                'invalid_message' => "La valeur saisie n'est pas un nombre valide.",
                "required" => false
            ])
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
            'data_class' => SuiviRetour::class,
        ]);
    }
}
