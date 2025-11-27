<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Coaster;
use App\Entity\Park;
use Dom\Entity;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CoasterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', options: ['label' => 'Nom du coaster'])
            ->add('maxSpeed', options: ['label' => 'Vitesse max. (km/h)'])
            ->add('length')
            ->add('maxHeight')
            ->add('operating', ChoiceType::class, options: [
                'label' => 'En fonctionnement',
                'choices' => [
                    'Oui' => true,
                    'Non' => false
                ],
                'expanded' => true,
            ])
            // EntityType::class = Symfony\Bridge\Doctrine\Form\Type\EntityType
            ->add('park', EntityType::class, [
                'class' => Park::class,
                'required' => false,
                'group_by' => 'country'
            ])

            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
                'query_builder' => function (\App\Repository\CategoryRepository $cr) {
                    return $cr->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                },
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Coaster::class,
        ]);
    }
}
