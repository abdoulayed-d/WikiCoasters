<?php

namespace App\Form;

use App\Entity\Park;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;

class ParkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $year = range(date("Y"), 1950);
        $builder
            ->add('name')
            ->add('country', CountryType::class, [
                'preferred_choices' => [
                    'France' => 'FR',
                    'Allemagne' => 'DE',
                    'Espagne' => 'ES',
                    'Italie' => 'IT',
                    'États-Unis' => 'US',
                ],
                'placeholder' => 'Choisir un pays',
            ])
            ->add('openingYear', ChoiceType::class, options: [
                'choices' => array_combine($year, $year)
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Park::class,
        ]);
    }
}
