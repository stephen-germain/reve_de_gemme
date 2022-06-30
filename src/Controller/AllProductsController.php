<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllProductsController extends AbstractController
{
    #[Route('/produits', name: 'app_all_products')]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productsRepository): Response
    {
        $bracelet = $categoriesRepository->findAllByCategory('Bracelets', '1');
        $collier = $categoriesRepository->findAllByCategory('Colliers', '2');
        $pierre = $categoriesRepository->findAllByCategory('Pierres', '3');
        $produit = $productsRepository->findAll();

        return $this->render('all_products/index.html.twig', [
            'bracelets' => $bracelet,
            'colliers' => $collier,
            'pierres' => $pierre,
            'products' => $produit,
        ]);
    }
    #[Route('/produits/bracelets', name: 'wristbands_products')]
    public function viewWristbandsCategory(CategoriesRepository $categoriesRepository): Response
    {
        $bracelet = $categoriesRepository->findAllByCategory('bracelets', '1');

        return $this->render('all_products/wristbandsCategory.html.twig', [
            'bracelets' => $bracelet,
        ]);
    }

    #[Route('/produits/colliers', name: 'necklaces_products')]
    public function viewNecklacesCategory(CategoriesRepository $categoriesRepository): Response
    {
        $collier = $categoriesRepository->findAllByCategory('colliers', '2');
        return $this->render('all_products/necklacesCategory.html.twig', [
            'colliers' => $collier,
        ]);
    }

    #[Route('/produits/mineraux', name: 'minerals_products')]
    public function viewMineralsCategory(CategoriesRepository $categoriesRepository): Response
    {
        $pierre = $categoriesRepository->findAllByCategory('pierres', '3');
        return $this->render('all_products/mineralsCategory.html.twig', [
            'pierres' => $pierre,
        ]);
    }

    #[Route('/produits/bracelets/{id}', name: 'wristbands_details')]
    public function viewWristbandsDetails(CategoriesRepository $categoriesRepository, $id): Response
    {
        // $bracelet = $categoriesRepository->findAllByCategory('bracelets', '1');
        $bracelet = $categoriesRepository->find($id);

        return $this->render('all_products/wristbandsDetails.html.twig', [
            'bracelets' => $bracelet,
        ]);
    }

    #[Route('/produits/collier/{id}', name: 'necklaces_details')]
    public function viewNecklacesDetails(CategoriesRepository $categoriesRepository, $id): Response
    {
        // $bracelet = $categoriesRepository->findAllByCategory('bracelets', '1');
        $collier = $categoriesRepository->find($id);

        return $this->render('all_products/necklacesDetails.html.twig', [
            'colliers' => $collier,
        ]);
    }

    #[Route('/produits/mineraux/{id}', name: 'minerals_details')]
    public function viewMineralsDetails(CategoriesRepository $categoriesRepository, $id): Response
    {
        // $bracelet = $categoriesRepository->findAllByCategory('bracelets', '1');
        $pierre = $categoriesRepository->find($id);

        return $this->render('all_products/mineralsDetails.html.twig', [
            'pierres' => $pierre,
        ]);
    }
}
