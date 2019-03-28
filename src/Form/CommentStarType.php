<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use App\Form\ApplicationType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentStarType extends ApplicationType
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
                        'step' => 2
                    ]
                ]))
            ->add('article', EntityType::class, array(
                'class' => Article::class,
                'choice_label' => 'title'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}
