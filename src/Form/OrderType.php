<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\Paiement;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('client', ClientType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
            ])
            ->add('paiement', PaiementType::class, [
                'class' => Paiement::class,
                'choice_label' => 'id',
            ])
            ->add('product', EntityType::class, [
                'class' => Product::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
