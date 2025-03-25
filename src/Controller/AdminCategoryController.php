<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\ProductRepository;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/admin')]
final class AdminCategoryController extends AbstractController
{
    #[Route('/category/liste', name: 'admin_category_liste')]
    public function liste(CategoryRepository $categoryRepository): Response
    {

        $categories = $categoryRepository->findAll();

        return $this->render('admin_category/index.html.twig', [

            'categories' => $categories,

        ]);
    }

    #[Route('/category/{id}', name: 'admin_category_item')]
    public function show(CategoryRepository $categoryRepository, int $id, ProductRepository $productRepository): Response
    {
        $category = $categoryRepository->find($id);
        $games = $productRepository->findBy(['category' => $id]);

        if ($category != null) {

            return $this->render('admin_category/item.html.twig', [

                'category' => $category,
                'games' => $games,

            ]);
        } else {
            return $this->redirectToRoute('admin_category_liste');
        }
    }

    #[Route('/add_category', name: 'admin_category_add')]
    public function add(EntityManagerInterface $em, Request $request)
    {

        $category = new Category();

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($category);
            $em->flush();
        }

        return $this->render('/admin_category/addcateg.html.twig', [

            'form' => $form->createView(),
        ]);
    }

    #[Route('/edit_category/{id}', name: 'admin_category_edit')]
    public function edit($id, CategoryRepository $categoryRepository, EntityManagerInterface $em, Request $request)
    {

        $category = $categoryRepository->find($id);

        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($category);
            $em->flush();
        }


        return $this->render('admin_category/editcateg.html.twig', [

            'form' => $form,
            'category' => $category,
        ]);
    }

    #[Route('/rem_category/{id}', name: 'admin_category_rm')]
    public function remove($id, CategoryRepository $categoryRepository, EntityManagerInterface $em)
    {

        $category = $categoryRepository->find($id);

        $em->remove($category);
        $em->flush();

        return $this->redirectToRoute('admin_category_liste');
    }
}
