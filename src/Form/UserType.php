<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ->add('email')
            // ->add('roles')
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nickname', TextType::class,[
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'constraints' => [
                    
                    new Length([
                        'min' => 1,
                        'minMessage' => 'Your nickname should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                        'maxMessage' => 'Your nickname should be maximum {{ limit }} characters',

                    ]),
                ],
            ])
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
                'years'  => range(date('Y')-100, date('Y')-19),
                ])
            ->add('language', TextType::class)
            ->add('nationality', TextType::class)
            ->add('photo', FileType::class)
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    "Rather not say" => 3,
                    'Female' => 1,
                    'Male'   => 2,
                ]
            ])
            // ->add('createdAt')
            ->add('description', TextareaType::class,[
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'constraints' => [
                    
                    new Length([
                        'max' => 300,
                        'maxMessage' => 'Your descripton should be maximum {{ limit }} characters',

                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
