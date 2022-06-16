<?php

namespace App\Controller;

use App\Entity\Expositions;
use App\Form\ExpostionFormType;
use App\Repository\ExpositionsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminExpositionsController extends AbstractController
{
    #[Route('/admin/expositions', name: 'app_admin_expositions')]
    public function index(ExpositionsRepository $expositionsRepository): Response
    {
        $exposition = $expositionsRepository->findAll();

        return $this->render('admin/adminExpositions.html.twig', [
            'expositions' => $exposition,
        ]);
    }

    #[Route('/admin/expositions/ajout', name: 'create_expositions')]
    public function expostionsCreate(Request $request, ManagerRegistry $doctrine): Response
    {
        $exposition = new Expositions();

        $form = $this->createForm(ExpostionFormType::class, $exposition);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $manager = $doctrine->getManager();
                $manager->persist($exposition);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La date de l\'exposition à bien été ajoutée'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('app_admin_expositions');
        }

        return $this->render('admin/adminExpositionForm.html.twig', [
            'formExposition' => $form->createView(),
        ]);
    }

    #[Route('/admin/expositions/modifier{id}', name: 'update_expositions')]
    public function expostionsUpdate(ExpositionsRepository $expositionsRepository, Request $request, ManagerRegistry $doctrine, $id): Response
    {
        $exposition = $expositionsRepository->find($id);

        $form = $this->createForm(ExpostionFormType::class, $exposition);
        $form->handleRequest($request);

        if($form->isSubmitted()){
            if($form->isValid()){
                $manager = $doctrine->getManager();
                $manager->persist($exposition);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La date de l\'exposition à bien été modifiée'
                );
            }
            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }

            return $this->redirectToRoute('app_admin_expositions');
        }
       
        return $this->render('admin/adminExpositionForm.html.twig', [
            'formExposition' => $form->createView(),
        ]);
    }

    #[Route('/admin/expositions/supprimer{id}', name: 'delete_expositions')]
    public function expostionsDelete(ExpositionsRepository $expositionsRepository, ManagerRegistry $doctrine, $id): Response
    {
        $exposition = $expositionsRepository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($exposition);
        $manager->flush();
        $this->addFlash(
            'success',
            'La date de l\'exposition à bien été supprimée'
        );

        return $this->redirectToRoute('app_admin_expositions');
    }
}
