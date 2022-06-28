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
                'required' => false,
                'label' => "Contrat",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('agreement', CheckboxType::class, [
                'required' => false,
                'label' => "Convention de stage",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('convocation', CheckboxType::class, [
                'required' => false,
                'label' => "Convocation",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('trainerFolder', CheckboxType::class, [
                'required' => false,
                'label' => "Dossier formateur (Complet)",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('certificate', CheckboxType::class, [
                'required' => false,
                'label' => "Attestation de fin de stage",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('empowermentTitle', CheckboxType::class, [
                'required' => false,
                'label' => "Titre d'habilitation",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('invoice', CheckboxType::class, [
                'required' => false,
                'label' => "Facture",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('survey', CheckboxType::class, [
                'required' => false,
                'label' => "Sondage",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('settlement', CheckboxType::class, [
                'required' => false,
                'label' => "Règlement",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('signInSheet', CheckboxType::class, [
                'required' => false,
                'label' => "Feuille d'émargement",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
            ])
            ->add('frontPage', CheckboxType::class, [
                'required' => false,
                'label' => "Page de garde",
                'attr'=>[
                    'class' => 'option-input radio'
                ]
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
