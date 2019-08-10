<?php

namespace App\Service\Article;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;

class ProductService
{
    /** @var ProductRepository  */
    protected $productRepository;

    /** @var EntityManagerInterface  */
    protected $entityManager;

    /**
     * @param ProductRepository $productRepository
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        ProductRepository $productRepository,
        EntityManagerInterface $entityManager
    ) {
        $this->productRepository = $productRepository;
        $this->entityManager = $entityManager;

    }

    /**
     * @return Product[]
     */
    public function findAll(): array
    {
        return $this->productRepository->findAll();
    }

    /**
     * @param Product $product
     */
    public function editOrCreate(Product $product): void
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
    }

    /**
     * @param Product $product
     */
    public function delete(Product $product): void
    {
        $this->entityManager->remove($product);
        $this->entityManager->flush();
    }
}