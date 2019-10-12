<?php

namespace App\Form;

use App\Entity\Product;
use App\Provider\LocaleCurrencyProvider;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add(
                'description',
                TextareaType::class,
                [
                    'constraints' => [new Length(['min' => 100])]
                ]
            )
            ->add(
                'priceGross',
                MoneyType::class,
                [
                    'currency' => LocaleCurrencyProvider::get(\Locale::getDefault()),
                ]
            )
            ->add('save', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
