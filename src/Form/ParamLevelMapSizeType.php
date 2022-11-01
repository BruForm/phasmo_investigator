<?php

namespace App\Form;

use App\Entity\Level;
use App\Entity\MapSize;
use App\Entity\ParamLevelMapSize;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class ParamLevelMapSizeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('value')
            ->add('duration', TimeType::class, [
                'widget' => 'choice',
                'with_seconds' => 'true',
            ])
            ->add('level', EntityType::class, [
                'class' => Level::class,
                'label' => 'Level :',
            ])
            ->add('mapSize', EntityType::class, [
                'class' => MapSize::class,
                'label' => 'Map size :',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ParamLevelMapSize::class,
        ]);
    }
}
