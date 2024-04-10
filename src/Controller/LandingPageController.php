<?php

namespace App\Controller;
use DateTimeImmutable;
use App\Entity\Client;
use App\Entity\Order;
use App\Entity\Paiement;
use App\Entity\Product;
use App\Form\ClientType;
use App\Form\OrderType;
use App\Repository\ProductRepository;
use App\Repository\PaiementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LandingPageController extends AbstractController
{
    #[Route('/', name: 'landing_page')]
    public function index(Request $request, EntityManagerInterface $entityManager, ProductRepository $productRepository, PaiementRepository $paiementRepository): Response
    {
        $client = new Client(); // Crée une nouvelle instance de l'entité Order
        $form = $this->createForm(ClientType::class, $client);
        // Crée le formulaire avec l'entité Order
        $products = $productRepository->findAll();

        $paiement = new Paiement;
        $order = new Order;
        // Gestion de la requête post-envoi du formulaire
        $form->handleRequest($request);
        // $form->sendApiRequest($order);
        if ($form->isSubmitted() && $form->isValid()) {
            // dd($client);
            // Utiliser le manager de Doctrine pour persister et flush les entités
            
            $productId = $request->get('order')['cart']['cart_products'][0];
            $paymentMethodRequest = $request->get('order')['payment_method'];
            // utiliser le repository pour trouver la bonne méthode de paiement et le bon productId
            $product = $productRepository->findOneBy(['id' => $productId]);

        
            $billing = $form->get('billingAddress')->getData();
            $shipping = $form->get('shippingAddress')->getData();
            $entityManager->persist($billing);
            $entityManager->persist($shipping);
            $entityManager->persist($client); // Persiste l'entité Order dans la base de données
            $entityManager->flush(); // Enregistre les changements dans la base de données

            $paiement->setPaiementMode('stripe');
            $order->setClient($client);
            $order->setPaiement($paiement);
            $order->setProduct($product);

            $entityManager->persist($order);
            $entityManager->persist($order);

            $paiement->setStatus(0);
            $paiement->setAmount($order->getProduct()->getPrice());
            $paiement->setCreatedAt(new DateTimeImmutable());
            $order->setPaiement($paiement);

            $this->sendApiRequest($order);

            

            if($paiement->getPaiementMode() === 'stripe') {
                return $this->redirectToRoute('stripe_checkout', ['id' => $order->getId()]);
            }



            // Redirection vers la page de confirmation
            return $this->redirectToRoute('confirmation');
        }

        // Passe le formulaire au template
        return $this->render('landing_page/index_new.html.twig', [
            'form' => $form->createView(),
            'products' => $products,
        ]);
        
    }

    #[Route('/confirmation', name: 'confirmation')]
    public function confirmation(): Response
    {
        return $this->render('landing_page/confirmation.html.twig');
    }


    private function sendApiRequest(Order $order): void { 
        // dd($order);
        $client = new \GuzzleHttp\Client();
        $client->request('POST', 'https://api-commerce.simplon-roanne.com/order', [
            'headers' => [
                'Authorization' => 'Bearer mJxTXVXMfRzLg6ZdhUhM4F6Eutcm1ZiPk4fNmvBMxyNR4ciRsc8v0hOmlzA0vTaX'
            ],
            'json' => [
            'order' => [
                'id' => $order->getId(),
                'product' => $order->getProduct()->getName(),
                'payment_method' => $order->getPaiement()->getPaiementMode(),
                'status' => "WAITING",
                'client' => [
                'firstname' => $order->getClient()->getFirstName(),
                'lastname' => $order->getClient()->getlastName(),
                'email' => $order->getClient()->getEmail(),
                'phone' => $order->getClient()->getPhone(),
                 ],
                'addresses' => [
                'billing' => [
                'address_line1' => $order->getClient()->getBillingAddress()->getAddress(),
                'address_line2' => $order->getClient()->getBillingAddress()->getAddressLine2(),
                'city' => $order->getClient()->getBillingAddress()->getCity(),
                'zipcode' => $order->getClient()->getBillingAddress()->getPostalCode(),
                'country' => $order->getClient()->getBillingAddress()->getCountry(),
                'phone' => $order->getClient()->getPhone(),
                ],
                'shipping' => [
                'address_line1' => $order->getClient()->getShippingAddress()->getAddress(),
                'address_line2' => $order->getClient()->getShippingAddress()->getAddressLine2(),
                'zipcode' => $order->getClient()->getShippingAddress()->getPostalCode(),
                'city' => $order->getClient()->getShippingAddress()->getCity(),
                'country' => $order->getClient()->getShippingAddress()->getCountry(),
                'phone' => $order->getClient()->getPhone(),
                ]

 
             ]    
            ]
            ]
        ]);
    }
}
