<?php

namespace App\Form;

use App\Entity\ToDoList;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ToDoListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Contract', CheckboxType::class, [
                "required" => false
            ])
            ->add('agreement', CheckboxType::class, [
                "required" => false
            ])
            ->add('convocation', CheckboxType::class, [
                "required" => false
            ])
            ->add('trainerFolder', CheckboxType::class, [
                "required" => false
            ])
            ->add('certificate', CheckboxType::class, [
                "required" => false
            ])
            ->add('empowermentTitle', CheckboxType::class, [
                "required" => false
            ])
            ->add('invoice', CheckboxType::class, [
                "required" => false
            ])
            ->add('survey', CheckboxType::class, [
                "required" => false
            ])
            ->add('settlement', CheckboxType::class, [
                "required" => false
            ])
            ->add('signInSheet', CheckboxType::class, [
                "required" => false
            ])
            ->add('frontPage', CheckboxType::class, [
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ToDoList::class,
        ]);
    }
}
