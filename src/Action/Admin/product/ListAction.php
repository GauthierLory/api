<?php

namespace App\Action\Admin\product;

use App\Action\Action;
use App\Security\Utils\AdminAccess;
use App\Table\Admin\ProductDatatable;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ListAction extends Action
{
    use AdminAccess;

    /** @var ProductDatatable  */
    private $productDatatable;

    /**
     * @param ProductDatatable $productDatatable
     */
    public function __construct(
        ProductDatatable $productDatatable
    ) {
        $this->productDatatable = $productDatatable;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request): Response
    {
        $this->productDatatable->handleRequest($request);
        if ($this->productDatatable->isCallback()) {
            return $this->productDatatable->response();
        }
        return $this->render('bo/pages/product/list.twig', [
            'datatable' => $this->productDatatable->render()
        ]);
    }
}