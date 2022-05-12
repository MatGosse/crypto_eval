<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Wallet;
use App\Repository\WalletRepository;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(WalletRepository $walletRepository): Response
    {
        /*--------------------------------------------- get all data transactions*/
        
        $data = $walletRepository->findAll();

        /*--------------------------------------------- call of the template*/

        return $this->render('default/index.html.twig', [
            'controller_name' => 'DefaultController',
            'data_wallet'=> $data
        ]);
    }
}
