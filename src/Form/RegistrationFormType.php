<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use App\DataFixtures\Departements;



class RegistrationFormType extends AbstractType
{


   

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        // $departments = require __DIR__ . '/../DataFixtures/departements.php';
        $departements = new Departements();
        $list = $departements->getDepartements();
        $builder
        ->add('email', TextType::class, [
            'label' => 'Email *',
            'required' => true,
            'constraints' => [
                new NotBlank([
                    'message' => 'Veuillez entrer une adresse email',
                ]),
                new Email([
                    'message' => 'Veuillez entrer une adresse email valide',
                ]),
            ],
        ])
            ->add('nom', TextType::class, [
                'label' => 'Nom *',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre nom',
                    ]),
                ],
            ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom *',
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer votre prénom',
                    ]),
                ],
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'attr' => ['type' => 'text'],

            ])
            ->add('departement', ChoiceType::class, [
                'choices' => array_flip($list),
                'choice_label' => function ($value) use ($list) {
                    return $list[$value] . ' (' . $value . ')';
                },
            ])
            ->add('adresse')
            ->add('codePostale')
            ->add('ville')
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accepter les conditions *',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'Vous devez accepter nos conditions',
                    ]),
                ],
            ])
            ->add('plainPassword', PasswordType::class, [

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('confirmPassword', PasswordType::class, [

                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un mot de passe',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit comporter au moins {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
