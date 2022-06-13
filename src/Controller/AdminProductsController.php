<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductFormType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{
    #[Route('/admin/produits', name: 'admin_products')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $product = $productsRepository->findAll();

        return $this->render('admin/adminProducts.html.twig', [
            'products' => $product,
        ]);
    }

    #[Route('/admin/produits/ajout', name: 'create_products')]
    public function productsCreate( Request $request, ManagerRegistry $doctrine): Response
    {
        $product = new Products();

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);

        $img = $form['image']->getData();

        if($form->isSubmitted()){
            if($form->isValid()){
                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newImg = $nomImg.'.'.$extensionImg;
            
                try{
                    $img ->move(
                        $this->getParameter('images_produits'),
                        $newImg
                    );
                }
                catch(FileException $e){
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de l\'importation de l\'image'
                    );
                }

                $product->setImage($newImg);

                $manager = $this->$doctrine->getManager();
                $manager->persist($product);
                $manager->flush($product);
                $this->addFlash(
                    'success',
                    'Le produit à bien été ajouté'
                );


            }

            else{
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_products');
        }
        return $this->render('admin/adminProducts.html.twig', [
            'products' => $product,
        ]);
    }
}
