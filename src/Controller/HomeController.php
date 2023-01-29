<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductsRepository;

class HomeController extends AbstractController
{

    #[Route('/', 'home', methods: ['GET'])]
    public function index(CategoriesRepository $categoriesRepository, ProductsRepository $productRepository): Response
    {


        return $this->render('home.html.twig', [
            'products' => $productRepository->findAll(),
            'categories' => $categoriesRepository->findBy(
                [],
                ['categoryOrder' => 'asc']
            )

        ]);
    }
}
