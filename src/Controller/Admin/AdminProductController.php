<?php

namespace App\Controller\Admin;

use App\Controller\ProductController;
use App\Entity\Product;
use App\Event\ProductAddedEvent;
use App\Form\ProductType;
use App\Provider\LocaleCurrencyProvider;
use App\Repository\ProductRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\LegacyEventDispatcherProxy;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductController extends ProductController
{
    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = LegacyEventDispatcherProxy::decorate($eventDispatcher);
    }

    /**
     * @Route("/admin/new-product", name="admin_new_product")
     * @param Request $request
     * @param ProductRepository $repository
     * @return Response
     */
    public function newProduct(Request $request, ProductRepository $repository): Response
    {
        $product = new Product();
        $product->setPriceCurrency(LocaleCurrencyProvider::get($request->getLocale()));
        $form = $this->createForm(ProductType::class, $product);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            return $this->processProductFormData($repository, $form);
        }

        return $this->render('product/admin/new_product.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param ProductRepository $repository
     * @param FormInterface $form
     * @return RedirectResponse
     */
    private function processProductFormData(ProductRepository $repository, FormInterface $form): RedirectResponse
    {
        $product = $form->getData();
        $repository->saveProduct($product);

        $this->addFlash('success', 'Product added');
        $this->eventDispatcher->dispatch(new ProductAddedEvent($product));

        return $this->redirectToRoute('products');
    }
}
