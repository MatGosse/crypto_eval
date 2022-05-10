<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteTransactionController extends AbstractController
{
    /**
     * @Route("/delete/transaction", name="app_delete_transaction")
     */
    public function index(): Response
    {
        return $this->render('delete_transaction/index.html.twig', [
            'controller_name' => 'DeleteTransactionController',
        ]);
    }
}
