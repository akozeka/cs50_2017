<?php

namespace AppBundle\Form;

use AppBundle\Entity\Office;
use AppBundle\Form\Type\AddressType;
use AppBundle\Form\Type\GenderType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use AppBundle\Utils\Registration;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('gender', GenderType::class)
            ->add('firstName', TextType::class, ['filter_emojis' => true])
            ->add('lastName', TextType::class, ['filter_emojis' => true])
            ->add('birthdate', BirthdayType::class, [
                'widget' => 'choice',
                'years' => $options['years'],
                'placeholder' => [
                    'year' => 'YYYY',
                    'month' => 'MM',
                    'day' => 'DD',
                ],
            ])
            ->add('address', AddressType::class)
            ->add('office', EntityType::class, [
                'class' => Office::class,
                'choice_label' => 'fullName',
                'query_builder' => function (EntityRepository $repository) {
                    return $repository->createQueryBuilder('o')->orderBy('o.name', 'ASC');
                },
                'placeholder' => 'Choose office...',
            ])
            ->add('password', RepeatedType::class, ['type' => PasswordType::class])
            ->add('conditions', CheckboxType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $years = range((int) date('Y') - 15, (int) date('Y') - 100);

        $resolver->setDefaults([
            'data_class' => Registration::class,
            'validation_groups' => ['Default', 'Registration'],
            'allow_extra_fields' => true, // reCaptcha
            'years' => array_combine($years, $years),
        ]);
    }

    public function getBlockPrefix()
    {
        return '';
    }
}
