<?php


namespace App\Action\Admin\product;


use App\Action\Action;
use App\Entity\Product;
use App\Service\Article\ProductService;

class DeleteAction extends Action
{
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
     * @param Product $product
     */
    public function __invoke(Product $product)
    {
        $this->productService->delete($product);
    }
}