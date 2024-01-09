<?php

namespace App\Form;

use App\Entity\OrderItem;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;


class AddToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('quantity', IntegerType::class, [
            'label' => 'Quantité',
            'constraints' => new GreaterThan([
                'value' => 0,
                'message' => 'La quantité doit être supérieure à zéro.'
            ]),
            'attr' => [
                'class' => 'quantity-input', // Ajoutez une classe CSS pour cibler le champ de quantité
                'value' => 0, // Valeur par défaut de 0
            ],
        ])
        ->add('increase_quantity', ButtonType::class, [
            'label' => '+',
            'attr' => [
                'class' => 'noDisplay', // Ajoutez une classe CSS pour cibler le bouton d'augmentation
            ],
        ])
        ->add('decrease_quantity', ButtonType::class, [
            'label' => '-',
            'attr' => [
                'class' => 'noDisplay', // Ajoutez une classe CSS pour cibler le bouton de diminution
            ],
        ]);
        
        $builder->add('add', SubmitType::class, [
            'label' => 'Ajouter au panier'
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OrderItem::class,
        ]);
    }
}
