<?php

namespace AppBundle\Form;

use AppBundle\Entity\Office;
use AppBundle\Entity\OfficeCategory;
use AppBundle\Entity\User;
use AppBundle\Form\Type\AddressType;
use AppBundle\Form\Type\GeoPointType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OfficeFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('categories', EntityType::class, [
                'class' => OfficeCategory::class,
                'choice_label' => 'name',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('oc')->orderBy('oc.name', 'ASC');
                },
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('users', EntityType::class, [
                'class' => User::class,
                'choice_label' => function (User $user) {
                    $office = $user->getOffice();

                    return $user->getFullNameReversed().($office === null ? ' (Not employeed)' : '');
                },
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createActiveUsersQB();
                },
                'required' => false,
                'multiple' => true,
                'expanded' => true,
                'by_reference' => false,
            ])
            ->add('name', TextType::class)
            ->add('postAddress', AddressType::class)
            ->add('coordinates', GeoPointType::class)
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Office::class,
        ]);
    }
}
