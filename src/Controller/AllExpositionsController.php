<?php

namespace App\Controller;

use App\Repository\ExpositionsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AllExpositionsController extends AbstractController
{
    #[Route('/expositions', name: 'app_all_expositions')]
    public function index(ExpositionsRepository $expositionsRepository): Response
    {
        $exposition = $expositionsRepository->findLastFive();

        return $this->render('all_expositions/index.html.twig', [
            'expositions' => $exposition,
        ]);
    }
}
