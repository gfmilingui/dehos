<?php

namespace App\Form;

use App\Entity\ClientCategorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ClientCategorieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => "Nom de la catégorie *",
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le nom",
                    'class' => "form-control form-control-sm",
                ],
                'required' => true,
            ])
            ->add('label', TextType::class, [
                'label' => "Label",
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3'],
                'attr' => [
                    'placeholder'=> "Saisir le label",
                    'class' => "form-control form-control-sm",
                ],
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-6'],
                'attr' => [
                    'placeholder'=> "Saisir la description",
                    'class' => "form-control form-control-sm",
                    'style' => "height:144px;"
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ClientCategorie::class,
        ]);
    }
}
