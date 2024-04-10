<?php

namespace App\Form;

use App\Entity\BillingAddress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BillingAddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => BillingAddress::class,
        ]);
    }
}
