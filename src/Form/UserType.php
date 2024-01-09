<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    private $authorizationChecker;

    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            // Modify fields for admin user
            $builder
                ->add('email')
                ->add('roles', ChoiceType::class, [
                    'choices' => [
                        'admin' => 'ROLE_ADMIN',
                    ],
                    'multiple' => true,
                    'expanded' => true,
                ])
                // ->add('points_fidelite')
                ->add('nom')
                ->add('prenom')
                ->add('telephone', TextType::class, [
                    'label' => 'Téléphone',
                    'attr' => ['type' => 'text'],
                   
                ])
                ->add('adresse')
                ->add('code_postale')
                ->add('ville');
        } else {
            // Modify fields for non-admin user
            $builder
                ->add('email')
                ->add('nom')
                ->add('prenom')
                ->add('telephone', TextType::class, [
                    'label' => 'Téléphone',
                    'attr' => ['type' => 'text'],
                   
                ])
                ->add('adresse')
                ->add('code_postale')
                ->add('ville');
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
