<?php

namespace App\Form;

use App\Entity\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class, [
                    "label"    => "Description",
                    "required" => false
                ])
            ->add('start_time', DateType::class, [
                "widget"   => "single_text",
                "label"    => "Start DateTime",
                "required" => false
                ])
            ->add('end_time', DateType::class, [
                "widget"   => "single_text",
                "label"    => "End DateTime",
                "required" => false
                ])
            ->add('location')
            ->add('priority')
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
