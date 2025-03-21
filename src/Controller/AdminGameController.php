<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class AdminGameController extends AbstractController
{
    #[Route('/admin/game/liste', name: 'admin_game_liste')]
    public function index(ProductRepository $productRepository): Response
    {
        $games = $productRepository->findAll();

        return $this->render('admin_game/index.html.twig', [
            'games' => $games,
        ]);
    }

    #[Route('admin/game/{id}', name: 'admin_game_item')]
    public function item(int $id, ProductRepository $productRepository): Response
    {
        $game = $productRepository->find($id);

        return $this->render('admin_game/item.html.twig', [
            'game' => $game,
        ]);
    }

    #[Route('admin/game_add', name: 'admin_add_game')]
    public function add(EntityManagerInterface $em, Request $request)
    {
        $game = new Product();

        $game->setIsReduced(false);

        $form = $this->createForm(ProductType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($game);
            $em->flush();
        }

        return $this->render('admin_game/game_add.html.twig', [

            'form' => $form->createView(),
        ]);
    }


    #[Route('admin/game_remove/{id}', name: 'admin_remove_game')]
    public function remove(int $id, ProductRepository $productRepository, EntityManagerInterface $em)
    {

        $game = $productRepository->find($id);

        $em->remove($game);

        $em->flush();

        return $this->redirectToRoute('admin_game_liste');
    }

    #[Route('admin/game_edit/{id}', name: 'admin_edit_game')]
    public function edit(int $id, ProductRepository $productRepository, EntityManagerInterface $em, Request $request)
    {
        $game = $productRepository->find($id);

        $form = $this->createForm(ProductType::class, $game);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($game);
            $em->flush();
        }

        return $this->render('admin_game/game_edit.html.twig', [
            'game' => $game,
            'form' => $form,
        ]);
    }
}
