<?php

namespace App\Form;

use App\Entity\CompanyType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;


class CompanyTypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class,[
                'row_attr'=>[
                    'class' => 'col-6'
                ],
                'label'=> 'Nom de la famille',
                'attr'=>[
                    'class' => 'form-control',
                    'placeholder' => 'Nom...'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CompanyType::class,
        ]);
    }
}
