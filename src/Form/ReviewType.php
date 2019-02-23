<?php

namespace App\Form;

use App\Entity\Product;
use App\Entity\Review;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ReviewType extends ApplicationType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('rating', \Symfony\Component\Form\Extension\Core\Type\IntegerType::class, $this->getConfiguration("Note sur 5",
                "Veuillez indiquer votre note de 0 à 5", [
                    'attr' => [
                        'min' => 0,
                        'max' => 5,
                        'step' => 1
                    ]
                ]))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Review::class,
        ]);
    }
}
