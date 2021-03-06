<?php

namespace AppBundle\Form\Type;

use AppBundle\Utils\ValueObject\Genders;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GenderType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'choices' => Genders::CHOICES,
            'expanded' => true,
        ]);
    }

    public function getParent()
    {
        return ChoiceType::class;
    }
}
