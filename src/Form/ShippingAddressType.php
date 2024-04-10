<?php

namespace App\Form;

use App\Entity\ShippingAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ShippingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstNameShippingAddress')
        ->add('lastNameShippingAddress')
            ->add('address')
            ->add('addressLine2')
            ->add('postalCode')
            ->add('city')
            ->add('country', ChoiceType::class, [
                'choices' => [
                    'FR' => 'France',
                    'BEL' => 'Belgique',
                    'LUX' => 'Luxembourg',
                ]
            ])
            ->add('phoneShippingAddress')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ShippingAddress::class,
        ]);
    }
}
