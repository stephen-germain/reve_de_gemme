<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductDetailsController extends AbstractController
{
    #[Route('/details/{id}', name: 'app_product_details')]
    public function index(ProductsRepository $productsRepository, $id): Response
    {
        $produit = $productsRepository->find($id);

        return $this->render('all_products/productDetails.html.twig', [
            'produits' => $produit,
        ]);
    }
}
