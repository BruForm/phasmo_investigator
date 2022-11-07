<?php

namespace App\Form;

use App\Entity\Characteristic;
use App\Entity\Entity;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class CharacteristicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type')
            ->add('name')
            ->add('description', TextareaType::class)
            ->add('value')
            ->add('entities', EntityType::class, [
                'class' => Entity::class,
                'query_builder' => function(EntityRepository $entityRepository){
                    return $entityRepository->createQueryBuilder('e')
                        ->addOrderBy('e.name', 'Asc');
                },
                'label' => 'Entities :',
                'attr' => [
                    'class' => 'form_checkbox',
                ],
                'required' => false,
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characteristic::class,
        ]);
    }
}
