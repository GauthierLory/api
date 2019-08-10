<?php

namespace App\Action\Admin\product;

use App\Action\Action;
use App\Entity\Product;
use App\Form\ProductType;
use App\Security\Utils\AdminAccess;
use App\Service\Article\ProductService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class EditAction extends Action
{
    use AdminAccess;

    /**
     * @var ProductService
     */
    private $productService;

    /**
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @param Request $request
     * @param Product $product
     * @return Response
     */
    public function __invoke(Request $request, Product $product): Response
    {
        $this->hasAccess();

        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->productService->editOrCreate($product);
        }
        $this->render('bo/pages/product/edit.twig', [
           'form' => $form->createView()
        ]);
    }
}