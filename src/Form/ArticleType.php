<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\ArticleTag;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required'=> true,
                ))
            ->add('tag', EntityType::class, array(
                'required'=> true,
                'class' => ArticleTag::class,
                'choice_label' => 'name'
            ))
//            ->add('images', CollectionType::class, array(
//                'entry_type' => ImageProductType::class,
//                'allow_add' => true,
//                'label' => "Image(s)"
//            ))
            ->add('price', IntegerType::class, array(
                'required'=> true,
                'attr' => array(
                    'min' => 1
                )
            ))
            ->add('description', TextareaType::class,array(
                'required'=> true,
                ))
            ->add('content', CKEditorType::class, array(
                'required'=> true,
                'config' => array(
                    'toolbar' => 'standard'
                )
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
