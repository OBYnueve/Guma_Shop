<?php

namespace App\Controller;

use App\Repository\UsersRepository;
use App\Entity\OrdersDetails;
use App\Entity\Products;
use App\Form\OrdersDetailsType;
use App\Repository\OrdersDetailsRepository;
use App\Repository\ProductsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/Panier', name: 'orders_', methods: ['GET'])]
class OrdersDetailsController extends AbstractController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(OrdersDetailsRepository $ordersDetailsRepository, SessionInterface $session, ProductsRepository $productsRepository): Response
    {

        $panier = $session->get("panier", []);

        //on "fabrique" les données
        $dataPanier = [];
        $total = 0;


        foreach ($panier as $id => $stock) {
            $product = $productsRepository->find($id);
            $dataPanier[] = [
                "produit" => $product,
                "quantite" => $stock,
            ];
            $total += $product->getPrice() * $stock;
        }

        return $this->render('orders_details/index.html.twig', compact(
            "dataPanier",
            "total"
        ));
    }
    #[Route('/add/{id}', name: 'add', methods: ['GET'])]
    public function add(Products $products, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get('panier', []);
        $id = $products->getId();
        $stocks = $products->getStock();


        if (!empty($panier[$id])) {
            $panier[$id]++;
        } else {
            $panier[$id] = 1;
        };
        if (!empty($stocks)) {
            $stocks++;
        } else {
            $stocks = "rupture de stock";
        };



        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("orders_index");
    }
    #[Route('/remove/{id}', name: 'remove', methods: ['GET'])]
    public function remove(Products $products, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get('panier', []);
        $id = $products->getId();

        if (!empty($panier[$id])) {
            if ($panier[$id] > 1) {
                $panier[$id]--;
            } else {
                unset($panier[$id]);
            }
        }

        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("orders_index");
    }

    #[Route('/delete/{id}', name: 'delete', methods: ['GET'])]
    public function delete(Products $products, SessionInterface $session)
    {
        //on récupère le panier actuel
        $panier = $session->get('panier', []);
        $id = $products->getId();

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }


        // On sauvegarde dans la session
        $session->set("panier", $panier);

        return $this->redirectToRoute("orders_index");
    }
}
