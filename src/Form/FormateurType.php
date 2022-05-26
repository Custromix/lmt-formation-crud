<?php

namespace App\Form;

use App\Entity\Formateur;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FormateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'Prénom',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Prenom'
                ]
            ])
            ->add('firstname', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'Nom',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Nom'
                ]
            ])
            ->add('trigram', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Trigramme',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Trigramme'
                ]
            ])
            ->add('skill', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Compétence',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Compétence'
                ]
            ])
            ->add('salary', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'Salaire',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Salaire'
                ]
            ])
            ->add('urssaf', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'URSSAF',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'URSSAF'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Formateur::class,
        ]);
    }
}
