<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;



#[Route('/shop')]
final class ShopController extends AbstractController
{
    #[Route('', name: 'shop_index')]
    public function index(): Response
    {
        return $this->render('shop/index.html.twig', [
            'controller_name' => 'ShopController',
        ]);
    }

    #[Route('/products', name: 'shop_products')]
    public function liste(ProductRepository $productRepository): Response
    {

        $products = $productRepository->findAll();

        return $this->render('shop/products.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/show/{item}', name: 'shop_item')]
    public function item(string $item, ProductRepository $productRepository): Response
    {
        $product = $productRepository->findOneBy(['label' => $item]);
        $similars = $productRepository->findThreeByCategory($product->getCategory(), $product->getLabel());

        return $this->render('shop/item.html.twig', [
            'product' => $product,
            'similars' => $similars,
        ]);
    }

    #[Route('/category/{category}', name: 'shop_category')]
    public function category(
        string $category,
        CategoryRepository $categoryRepository,
        ProductRepository $productRepository
    ): Response {

        $productsByCategory = $productRepository->findBy(['category' => $category]);

        return $this->render('shop/category.html.twig', [
            'products' => $productsByCategory,
        ]);
    }
}
