<?php

namespace App\Form;

use App\Entity\CompanyType;
use App\Entity\Contact;
use App\Entity\Customer;
use App\Entity\TrainingRequest;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('website')
            ->add('address')
            ->add('city')
            ->add('postal')
            ->add('CompanyType', EntityType::class, [
                'class' => CompanyType::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'allow_extra_fields' => true,
            'mapped' => false,
        ]);
    }
}
