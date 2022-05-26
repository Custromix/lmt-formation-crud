<?php

namespace App\Form;

use App\Entity\StandardTraining;
use App\Entity\TrainingType;
use App\Repository\TrainingTypeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('reference', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Référence',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Exemple_BE...'
                ]
            ])
            ->add('nom', TextType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'Nom de la formation',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Nom...'
                ]
            ])
            ->add('nbHours', IntegerType::class, [
                'row_attr'=>[
                    'class' => 'col-5'
                ],
                'label'=> 'Nombres d\'heures',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => '123...'
                ]
            ])
            ->add('trainingType', EntityType::class, [
                'class' => TrainingType::class,
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Groupe',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Groupe...'
                ]
            ])
            ->add('trainingPrice', IntegerType::class, [
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Prix de la formation',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => '123...€'
                ]
            ])
            ->add('materials', TextareaType::class, [
                'row_attr'=>[
                    'class' => 'col-11'
                ],
                'label'=> 'Liste des matériels',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => '- matériel 1...
- matériel 2...
...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StandardTraining::class,
        ]);
    }
}
