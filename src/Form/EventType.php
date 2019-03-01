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

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('date_start', DateType::class, array(
                 'widget' => 'choice',
                 'years'  => range(date('Y'), date('Y')+5),
                 'months' => range(date('m'), date('m')+12),
                 'days'   => range(date('d'), date('d')+31),
            ))
            ->add('date_end', DateType::class, array(
                'widget' => 'choice',
                'years'  => range(date('Y'), date('Y')+5),
                'months' => range(date('m'), date('m')+12),
                'days'   => range(date('d'), date('d')+31),
           ))
            ->add('photo', FileType::class, [
                'mapped' => false,
                'label' => 'Ajouter une photo',
            ])
            ->add('description', TextareaType::class)
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
