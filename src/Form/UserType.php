<?php

namespace App\Form;

use App\Entity\User;
use App\Security\Roles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public const FIELD_LAST_NAME = 'lastName';
    public const FIELD_FIRST_NAME = 'firstName';
    public const FIELD_EMAIL = 'email';
    public const FIELD_ROLES = 'roles';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(static::FIELD_LAST_NAME, TextType::class, [
                'attr' => [
                    'placeholder' => 'Prénom'
                ]
            ])
            ->add(static::FIELD_FIRST_NAME, TextType::class, [
                'attr' => [
                    'placeholder' => 'Nom'
                ]
            ])
            ->add(static::FIELD_EMAIL, EmailType::class, [
                'attr' => [
                    'placeholder' => 'Email'
                ]
            ])
            ->add(static::FIELD_ROLES, ChoiceType::class,  [
                'label' => 'Role : (par défaut User) ',
                'mapped' => true,
                'expanded' => true,
                'multiple' => true,
                'choices' => [
                    Roles::$list
                ]
            ])
            ->add('save', SubmitType::class);
//            ->add('password', RepeatedType::class, [
//                'type' => PasswordType::class,
//                'invalid_message' => 'The password fields must match.',
//                'options' => ['attr' => ['class' => 'password-field']],
//                'required' => true,
//                'first_options'  => ['label' => 'Password'],
//                'second_options' => ['label' => 'Confirm Password'],
//            ])
//            ->add('avatar', FileType::class, array('label' => 'Photo (png, jpeg)'))

    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
