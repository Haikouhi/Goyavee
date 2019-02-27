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

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        // TODO: Terminer de typer les datas et résoudre le problème concernant les id_location et organizer
        $builder
            ->add('name', TextType::class)
            ->add('date_start', DateType::class)
            ->add('date_end', DateType::class)
            ->add('photo', FileType::class)
            ->add('description', TextareaType::class)
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ]) 
            ->add('location', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'street_name'
            ])
            ->add('organizer', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'id'
            ]);






            // ->add(
            //     $builder->create('location', FormType::class, ['by_reference' => false])
            //     ->add('street_name', TextType::class)
            //     ->add('street_number', IntegerType::class)
            //     ->add('city', TextType::class)
            //     ->add('zip', IntegerType::class)
            //     ->add('country', CountryType::class)
            //     ->add('longitude')
            //     ->add('latitude'), EntityType::class, [
            //         'class' => Location::class,
            //     ])
            // ->add('created_at')
        
            }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
