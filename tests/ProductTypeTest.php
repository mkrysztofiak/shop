<?php

namespace App\Tests;

use App\Entity\Product;
use App\Form\ProductType;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\Validation;

class ProductTypeTest extends TypeTestCase
{
    protected function getExtensions()
    {
        $validator = Validation::createValidatorBuilder()
            ->enableAnnotationMapping()
            ->getValidator();

        return [
            new ValidatorExtension($validator),
        ];
    }

    public function testValidData()
    {
        $formData = [
            'name' => 'Test name of product',
            'description' => 'Lorem ipsum dolor sit amet consectetur adipiscing elit.',
            'priceGross' => 12.99,
        ];

        $productToCompare = new Product();
        $form = $this->factory->create(ProductType::class, $productToCompare);

        $product = new Product();
        $product->setName($formData['name']);
        $product->setDescription($formData['description']);
        $product->setPriceGross($formData['priceGross']);

        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($product, $productToCompare);

        $view = $form->createView();

        foreach (array_keys($formData) as $key) {
            $this->assertArrayHasKey($key, $view->children);
        }
    }
}
