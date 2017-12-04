<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\GeoPointEmbeddable;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GeoPointType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('latitude', NumberType::class, ['required' => false, 'scale' => 6])
            ->add('longitude', NumberType::class, ['required' => false, 'scale' => 6])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => GeoPointEmbeddable::class,
        ]);
    }
}
