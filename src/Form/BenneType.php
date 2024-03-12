<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Benne;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Service\AvailableOptions;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class BenneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero_serie', TextType::class, [
                'label' => 'Numéro de série *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir le numéro de série",
                    'class' => "form-control form-control-sm",
                ],
            ])
            ->add('label', TextType::class, [
                'label' => 'Label',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir le label",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false
            ])
            /*
            ->add('capacite', NumberType::class, [
                'label' => 'Capacité *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir la capacité",
                    'class' => "form-control form-control-sm",
                ],
                'invalid_message' => "La valeur saisie n'est pas un nombre valide.",
            ])
            */
            ->add('capacite', ChoiceType::class, [
                'label' => 'Capacité *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Choisir la capacité",
                    'class' => "form-select form-select-sm",
                ],
                'choices'  =>AvailableOptions::getCapaciteBenne()
            ])
            ->add('capacite_unite', ChoiceType::class, [
                'label' => 'Unité (Capacité de la benne) *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Choisir l'unité (Capacité de la benne)",
                    'class' => "form-select form-select-sm",
                ],
                'choices'  =>AvailableOptions::getCapaciteUnite()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Benne::class,
        ]);
    }
}
