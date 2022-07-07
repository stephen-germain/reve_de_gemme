<?php

namespace App\Controller;

use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $firstProducts = $productsRepository->findFourFirst();
        $nextProducts = $productsRepository->findFourAfter();
        $lastProducts = $productsRepository->findFourLast();

        return $this->render('home/index.html.twig', [
            'firstProducts' => $firstProducts,
            'nextProducts' => $nextProducts,
            'lastProducts' => $lastProducts,
        ]);
    }
}
