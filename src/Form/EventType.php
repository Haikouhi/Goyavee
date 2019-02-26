<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

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
            ->add('category') // TODO: ajouter un EntityType quand la class et la table category sera créée
            ->add('id_location')
            ->add('id_organizer')
            // ->add('created_at')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
