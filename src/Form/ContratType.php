<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\ConfigContrat;
use App\Entity\Contrat;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContratType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('numero', TextType::class, [
                'label' => 'Numero *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir le numero",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
                'disabled' => true,
            ])
            ->add('client', EntityType::class, [
                'label' => 'Client *',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Choisir le client",
                    'class' => "form-select form-select-sm",
                ],
                'class' => Client::class,
                'choice_label' => 'nom',
                // 'empty_data' => null,
                'placeholder'=> "Choisir le client",
                'required' => true
            ])
            ->add('date_debut', DateType::class, [
                'label' => 'Date début',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-2'],
                'attr' => [
                    'placeholder'=> "Saisir la date de début",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('date_fin', DateType::class, [
                'label' => 'Date fin',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-2'],
                'attr' => [
                    'placeholder'=> "Saisir la date de fin",
                    'class' => "form-control form-control-sm",
                ],
                'widget' => 'single_text',
                'required' => true
            ])
            ->add('titre_contrat', TextType::class, [
                'label' => 'Titre',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-4'],
                'attr' => [
                    'placeholder'=> "Saisir le titre",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-8'],
                'attr' => [
                    'placeholder'=> "Saisir la description",
                    'class' => "form-control form-control-sm",
                    'style' => "height:144px;"
                ],
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contrat::class,
        ]);
    }
}
