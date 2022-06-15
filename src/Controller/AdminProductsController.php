<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductFormType;
use App\Repository\ProductsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminProductsController extends AbstractController
{
    // public function __construct( ManagerRegistry $doctrine){}

    #[Route('/admin/produits', name: 'admin_products')]
    public function index(ProductsRepository $productsRepository): Response
    {
        $bracelet = $productsRepository->findOneByCategorie('1');
        $collier = $productsRepository->findOneByCategorie('2');
        $pierre = $productsRepository->findOneByCategorie('3');

        return $this->render('admin/adminProducts.html.twig', [
            'bracelets' => $bracelet,
            'colliers' => $collier,
            'pierres' => $pierre,
        ]);
    }

    #[Route('/admin/produits/ajout', name: 'create_products')]
    public function productsCreate(Request $request, ManagerRegistry $doctrine): Response
    {
        $product = new Products();

        $form = $this->createForm(ProductFormType::class, $product);
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

                $product->setImage($newImg);

                $manager = $doctrine->getManager();
                $manager->persist($product);
                $manager->flush($product);
                $this->addFlash(
                    'success',
                    'Le produit à bien été ajouté'
                );
            } else {
                $this->addFlash(
                    'danger',
                    'Une erreur est survenue'
                );
            }
            return $this->redirectToRoute('admin_products');
        }
        return $this->render('admin/adminProductForm.html.twig', [
            'formProduit' => $form->createView(),
        ]);
    }

    #[Route('/admin/produits/modifier{id}', name: 'update_products')]
    public function productUpdate(ProductsRepository $productsRepository, Request $request, $id, ManagerRegistry $doctrine): Response
    {
        $product = $productsRepository->find($id);

        $oldImg = $product->getImage();
        $oldImgPath = $this->getParameter('images_produits').'/'.$oldImg;

        $form = $this->createForm(ProductFormType::class, $product);
        $form->handleRequest($request);
        
        $img = $form['image']->getData();

        if($form->isSubmitted()){
            if($form->isValid()){
                if($oldImg != NULL){
                    unlink($oldImgPath);
                }
                $nomImg = md5(uniqid());
                $extensionImg = $img->guessExtension();
                $newImg = $nomImg.'.'.$extensionImg;

                try{
                    $img->move(
                        $this->getParameter('images_produits'),
                        $newImg
                    );
                }
                catch(Exception $e){
                    $this->addFlash(
                        'danger',
                        'Une erreur est survenue lors de la modification de l\'image'
                    );
                }

                $product->setImage($newImg);

                $manager = $doctrine->getManager();
                $manager->persist($product);
                $manager->flush();
        
                $this->addFlash(
                    'success',
                    'Le produit à bien été modifié'
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

        return $this->render('admin/adminProductForm.html.twig', [
            'formProduit' => $form->createView(),
        ]);
      
    }

    #[Route('/admin/produits/supprime{id}', name: 'delete_products')]
    public function productDelete(ProductsRepository $productsRepository, $id, ManagerRegistry $doctrine): Response
    {
        $product = $productsRepository->find($id);

        $manager = $doctrine->getManager();
        $manager->remove($product);
        $manager->flush($product);

        $this->addFlash(
            'success',
            'Le produit à bien été supprimé'
        );
        return $this->redirectToRoute('admin_products');
    }
}
