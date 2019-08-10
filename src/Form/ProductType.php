<?php


namespace App\Form;


use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public const FIELD_NAME = 'name';
    public const FIELD_DESCRIPTION = 'description';
    public const FIELD_PRICE = 'price';
    public const FIELD_IS_ACTIVE = 'isActive';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(static::FIELD_NAME, Type\TextType::class, [
                'label' => 'Nom du produit',
            ])
            ->add(static::FIELD_DESCRIPTION, Type\TextareaType::class, [
                'label' => 'Description du produit',
            ])
            ->add(static::FIELD_PRICE, Type\MoneyType::class, [
                'label' => 'Prix du produit',
            ])
            ->add(static::FIELD_IS_ACTIVE, Type\CheckboxType::class, [
                'label' => 'Activer',
                'required' => false,
            ]);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        parent::configureOptions($resolver);
        $resolver->setDefault('data_class', Product::class);
    }
}