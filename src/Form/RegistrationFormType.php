<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;


class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('nickname', TextType::class,[
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'constraints' => [
                    
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Your nickname should be at least {{ limit }} characters',
                        // max length allowed by Symfony for security reasons
                        'max' => 20,
                        'maxMessage' => 'Your nickname should be maximum {{ limit }} characters',

                    ]),
                ],
            ])
            ->add('firstname', TextType::class)
            ->add('birthdate', BirthdayType::class)
            ->add('language', LanguageType::class)
            ->add('nationality', CountryType::class)
            ->add('photo', FileType::class,[

                'required' => false,
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => [
                    'Female' => 1,
                    'Male'   => 2,
                    "Rather not say" => 3,
                ]
            ])
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
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
