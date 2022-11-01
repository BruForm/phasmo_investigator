<?php

namespace App\Form;

use App\Entity\Level;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LevelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('freeRunTime', TimeType::class, [
                'widget' => 'choice',
                'with_seconds'=>'true',
            ])
            ->add('huntGraceTime', TimeType::class, [
                'widget' => 'choice',
                'with_seconds'=>'true',
            ])
            ->add('sanityByPill')
            ->add('insurancePayment');
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Level::class,
        ]);
    }
}
