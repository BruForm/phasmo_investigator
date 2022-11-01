<?php

namespace App\Form;

use App\Entity\Characteristic;
use App\Entity\Entity;
use App\Entity\Evidence;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EntityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('specialMove', TextareaType::class)
            ->add('evidences', \Symfony\Bridge\Doctrine\Form\Type\EntityType::class, [
                'class' => Evidence::class,
                'label' => 'Evidences :',
                'attr' => [
                    'class' => 'form_checkbox',
                ],
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entity::class,
        ]);
    }
}
