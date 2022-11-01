<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\Evidence;
use App\Entity\OptionalGoal;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('utilisation', TextareaType::class)
            ->add('evidences', EntityType::class, [
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
            'data_class' => Equipment::class,
        ]);
    }
}
