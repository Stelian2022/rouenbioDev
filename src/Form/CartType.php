<?php

namespace App\Form;

use App\Entity\Order;
use App\Form\CartItemType;
use App\Manager\CartManager;
use Symfony\Component\Form\AbstractType;
use App\Form\EventListener\ClearCartListener;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CartType extends AbstractType
{
    private CartManager $cartManager;

    public function __construct(CartManager $cartManager)
    {
        $this->cartManager = $cartManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('items', CollectionType::class, [
                'entry_type' => CartItemType::class,
                
            ])
            ->add('save', SubmitType::class, [
                'attr' => ['i class' => 'fas fa-check'],
                'label' => ' '
            ])
            ->add('clear', SubmitType::class, [
                'attr' => ['i class' => 'fas fa-trash-alt'],
                'label' => ' '
            ]);
          


       
        $builder->addEventSubscriber(new ClearCartListener($this->cartManager));
       
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Order::class,
        ]);
    }
}
