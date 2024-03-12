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
use Symfony\Component\Form\Extension\Core\Type\RadioType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class SiteEditType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $client = $options['client'];
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
                'disabled' => true,
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
            ->add('contrat', EntityType::class, [
                'label' => 'Contrat',
                'label_attr' => ['class' => 'form-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-12'],
                'attr' => [
                    'placeholder'=> "Choisir le contrat",
                    'class' => "form-select form-select-sm",
                ],
                'class' => Contrat::class,
                // 'choice_label' => 'numero',
                'choice_label' => function ($contrat) {
                    // dump($contrat->getDisplayNameHtmlSpanInside());
                    // return $contrat->getDisplayName();
                    return $contrat->getDisplayNameV2();
                },
                'choices' => $client->getContrats(),
                'placeholder'=> "Aucun contrat lié",
                'empty_data' => null,
                'expanded'=>true,
                'multiple'=>false,
                'required' => false,
            ])
            /*
            ->add('answer12', ChoiceType::class, [
                'label' => 'Pays *',
                'label_attr' => ['class' => 'form-check-label'],
                'row_attr' => ['class' => 'mb-3 row-form form-check col-md-3'],
                'attr' => [
                    'placeholder'=> "Choisir le pays",
                    'class' => "form-check-input",
                ],
                // 'choices'  =>AvailableOptions::getPays(),
                'choices' => array(
                    'answer1' => '1',
                    'answer2' => '2',
                    'answer3' => '3',
                    'answer4' => '4'
                ),
                //'choices_as_values' => true,
                'expanded'=>true,
                'multiple'=>false,
                'mapped' => false
            ])
            */
            /*
            ->add('answer123', RadioType::class, [
                'label' => 'Pays *',
                'label_attr' => ['class' => 'form-check-label'],
                'row_attr' => ['class' => 'mb-3 row-form col-md-3 form-check'],
                'attr' => [
                    'placeholder'=> "Choisir le pays",
                    'class' => "form-check-input",
                ],
                'mapped' => false
            ])
            */
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
            'client' => array(),
        ]);
    }
}
