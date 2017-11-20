<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Country;
use AppBundle\Utils\Geo\Address;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $zipCode = $builder->create('zipCode', TextType::class, ['required' => false]);

        $zipCode->addModelTransformer(new CallbackTransformer(
            function ($data) {
                return $data;
            },
            function ($value) {
                return str_replace(' ', '', $value);
            }
        ));

        $builder
            ->add('country', EntityType::class, [
                'class' => Country::class,
                'choice_value' => function ($country) {
                    return ($country instanceof Country) ? $country->getCode() : $country;
                },
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('c')->orderBy('c.name', 'ASC');
                },
                'placeholder' => 'Choose country',
            ])
            ->add('city', TextType::class)
            ->add('address', TextType::class, ['required' => false])
            ->add($zipCode);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
            'error_bubbling' => false,
        ]);
    }
}
