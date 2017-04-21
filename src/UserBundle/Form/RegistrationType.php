<?php

namespace UserBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use UserBundle\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class RegistrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Prénom',
                )
            ))
            ->add('lastName', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Nom',
                )
            ))
            ->add('email', EmailType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Email',
                )
            ))
            ->add('plainPassword', PasswordType::class)
            ->add('postalCode', TextType::class, array(
                'label' => false,
                'attr' => array(
                    'placeholder' => 'Code Postal',
                )
            ))
            ->add('roles', ChoiceType::class, [
                'multiple' => true,
                'expanded' => true,
                'label' => 'Statut',
                'choices' => [
                    'Admin' => 'ROLE_ADMIN',
                    'Naturaliste' => 'ROLE_PRO',
                    'Particulier' => 'ROLE_PAR',
                ],
            ]);
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => User::class,
        ));
    }
}