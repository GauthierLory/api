<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, $this->getConfiguration("profile.old_password",
                "profile.old_password_placeholder"))
            ->add('newPassword', PasswordType::class, $this->getConfiguration("profile.new_password",
                "profile.new_password_placeholder"))
            ->add('confirmPassword', PasswordType::class, $this->getConfiguration("profile.confirm_password",
                "profile.confirm_password_placeholder"))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
