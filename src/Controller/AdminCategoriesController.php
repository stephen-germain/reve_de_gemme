<?php

namespace App\Controller;

use Exception;
use App\Entity\Categories;
use App\Form\CategorieFormType;
use App\Repository\CategoriesRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class AdminCategoriesController extends AbstractController
{
    #[Route('/admin/categories', name: 'app_admin_categories')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        $bracelet = $categoriesRepository->findAllByCategory('Bracelets', '1');
        $collier = $categoriesRepository->findAllByCategory('Colliers', '2');
        $pierre = $categoriesRepository->findAllByCategory('Pierres', '3');

        return $this->render('admin/adminCategories.html.twig', [
            'bracelets' => $bracelet,
            'colliers' => $collier,
            'pierres' => $pierre,
        ]);
    }

    #[Route('/admin/categories/ajout', name: 'create_categories')]
    public function categoriesCreate(Request $request, ManagerRegistry $doctrine): Response
    {
        $categorie = new Categories();

        $form = $this->createForm(CategorieFormType::class, $categorie);
        $form->handleRequest($request);

        $img = $form['image']->getData();

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newImg = $nomImg . '.' . $extensionImg;

                try {
                    $img->move(
                        $this->getParameter('images_produits'),
                        $newImg
                    );
                } catch (FileException $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation de l\'image'
                    );
                }

                $categorie->setImage($newImg);

                $type = 2;
                $categorie->setType($type);

                $manager = $doctrine->getManager();
                $manager->persist($categorie);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La catégorie à bien été ajoutée'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('app_admin_categories');
        }
        return $this->render('admin/adminCategorieForm.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }

    #[Route('/admin/categories/modifier/{id}', name: 'update_categories')]
    public function categoriesUpdate(Request $request, ManagerRegistry $doctrine, $id, CategoriesRepository $categoriesRepository): Response
    {
        $categorie = $categoriesRepository->find($id);

        $oldImg = $categorie->getImage();
        $oldImgPath = $this->getParameter('images_produits') . '/' . $oldImg;

        $form = $this->createForm(CategorieFormType::class, $categorie);
        $form->handleRequest($request);

        $img = $form['image']->getData();

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                if ($oldImg != NULL) {
                    unlink($oldImgPath);
                }
                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newImg = $nomImg . '.' . $extensionImg;

                try {
                    $img->move(
                        $this->getParameter('images_produits'),
                        $newImg
                    );
                } catch (Exception $e) {
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de la modification de l\'image'
                    );
                }

                $categorie->setImage($newImg);

                
                $manager = $doctrine->getManager();
                $manager->persist($categorie);
                $manager->flush();
                $this->addFlash(
                    'success',
                    'La catégorie à bien été modifiée'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('app_admin_categories');
        }
        return $this->render('admin/adminCategorieForm.html.twig', [
            'formCategorie' => $form->createView(),
        ]);
    }

    #[Route('/admin/categories/supprimer/{id}', name: 'delete_categories')]
    public function categoriesDelete(ManagerRegistry $doctrine, $id, CategoriesRepository $categoriesRepository): Response
    {
        $categorie = $categoriesRepository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($categorie);
        $manager->flush();
        $this->addFlash(
            'success',
            'La catégorie à bien été modifiée'
            );
       
        return $this->redirectToRoute('app_admin_categories'); 
    }
}
