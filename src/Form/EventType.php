<?php

namespace App\Form;

use App\Entity\Event;
use App\Entity\Location;
use App\Entity\User;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Doctrine\ORM\Query\AST\Functions\CurrentDateFunction;
use Symfony\Component\Intl\Data\Generator\CurrencyDataGenerator;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Validator\Constraints\Length;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('date_start', DateTimeType::class, [
                'widget' => 'single_text',
            ])
            ->add('date_end', DateTimeType::class, [
                'widget' => 'single_text']
            )
            ->add('photo', FileType::class, [
                'mapped' => false,
                'label' => 'Add a picture',
            ])
            ->add('description', TextareaType::class,[
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'constraints' => [
                    
                    new Length([
                        'max' => 290,
                        'maxMessage' => 'Your descripton should be maximum {{ limit }} characters',

                    ]),
                ],
            ])
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ]) 
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'required'   => false,
                
            ]);
        
            }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
