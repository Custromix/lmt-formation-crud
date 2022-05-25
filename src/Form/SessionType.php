<?php

namespace App\Form;

use App\Entity\Session;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SessionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('place')
            ->add('nbTrainee')
            ->add('estimatePrice')
            ->add('numberEstimate')
            ->add('purchaseOrder')
            ->add('note')
            ->add('Trainer')
            ->add('Status')
            ->add('ToDoList')
            ->add('Customer')
            ->add('StandardTraining')
            ->add('CustomizeTraining')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Session::class,
        ]);
    }
}
