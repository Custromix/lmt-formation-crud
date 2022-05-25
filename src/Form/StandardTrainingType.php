<?php

namespace App\Form;

use App\Entity\StandardTraining;
use App\Entity\TrainingType;
use App\Repository\TrainingTypeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StandardTrainingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('nbHours')
            ->add('trainingPrice')
            ->add('materials')
            ->add('reference')
            ->add('family')
            ->add('TrainingRequest')
            ->add('trainingType')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => StandardTraining::class,
        ]);
    }
}
