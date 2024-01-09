<?php

namespace App\Form;

use App\Entity\OrderItem;
use App\Manager\CartManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use App\Form\EventListener\UpdateCartItemListener;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class CartItemType extends AbstractType
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    private CartManager $cartManager;
    public function __construct(CartManager $cartManager, EntityManagerInterface $entityManager)
    {
        $this->cartManager = $cartManager;
        $this->entityManager = $entityManager;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity')
            ->add('update', SubmitType::class, [
                'attr' => ['i class' => 'fas fa-check'],
                'label' => ' '
            ]);

        $builder->addEventSubscriber(new UpdateCartItemListener($this->cartManager, $this->entityManager));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}
