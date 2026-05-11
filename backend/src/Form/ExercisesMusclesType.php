<?php

namespace App\Form;

use App\Entity\Exercises;
use App\Entity\ExercisesMuscles;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExercisesMusclesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('role')
            ->add('muscle', EntityType::class, [
                'class' => Exercises::class,
                'choice_label' => 'id',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ExercisesMuscles::class,
        ]);
    }
}
