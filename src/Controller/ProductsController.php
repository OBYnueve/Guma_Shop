<?php

namespace App\Controller;

use App\Entity\Products;
use App\Form\ProductsType;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends AbstractController
{
    /**
     * This function display all ingredients
     *
     * @param ProductsRepository $repository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    #[Route('/products', name: 'app_products', methods: ['GET'])]
    public function index(ProductsRepository $repository, PaginatorInterface $paginator, Request $request): Response
    {
        $product = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
        );
        return $this->render('products/index.html.twig', [
            'products' => $product
        ]);
    }

    #[Route('/products/nouveau', name: 'product.new', methods: ['GET', 'POST'])]
    public function new(): Response
    {
        $product = new Products();
        $form = $this->createForm(ProductsType::class, $product);

        return $this->render('products/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
