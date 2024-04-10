<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\Order1Type;
use App\Form\OrderType;
use App\Repository\OrderRepository;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/order/controlleur')]
class OrderController extends AbstractController
{
    #[Route('/', name: 'app_order_controlleur_index', methods: ['GET'])]
    public function index(OrderRepository $orderRepository, ProductRepository $productRepository): Response
    {
    $orders = $orderRepository->findAll();
    // $products = $productRepository->findAll();
    
    
        return $this->render('order_controlleur/index.html.twig', [
            'orders' => $orders,
            // 'products' => $products,
        ]);
    }

    #[Route('/new', name: 'app_order_controlleur_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $order = new Order();
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($order);
            $entityManager->flush();

            return $this->redirectToRoute('app_order_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order_controlleur/new.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_controlleur_show', methods: ['GET'])]
    public function show(Order $order): Response
    {
        return $this->render('order_controlleur/show.html.twig', [
            'order' => $order,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_order_controlleur_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(OrderType::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_order_controlleur_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('order_controlleur/edit.html.twig', [
            'order' => $order,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_order_controlleur_delete', methods: ['POST'])]
    public function delete(Request $request, Order $order, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$order->getId(), $request->request->get('_token'))) {
            $entityManager->remove($order);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_order_controlleur_index', [], Response::HTTP_SEE_OTHER);
    }
}
