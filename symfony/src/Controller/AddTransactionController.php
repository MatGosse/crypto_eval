<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Form\AddToWalletFormType;
use App\Entity\Wallet;

class AddTransactionController extends AbstractController
{
    /**
     * @Route("/add", name="app_add_transaction")
     */    
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {

        $form = $this->createForm(AddToWalletFormType::class);
        $form->handleRequest($request);

        /*--------------------------------------------- Check validity of form */

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            /*--------------------------------------------- Adding forms data to DataBase */
            
            $NewTransaction = new Wallet;
            $NewTransaction->setCryptoName($data['crypto_name']);
            $NewTransaction->setAmount($data['amount']);
            $NewTransaction->setInitialValue($data['initial_value']);
            $NewTransaction->setCurrentValue($data['initial_value']);
            $NewTransaction->setStatus(true);
            $NewTransaction->setCreationDate(new \DateTime('@'.strtotime('now')));

            $entityManager = $doctrine->getManager();
                
            $entityManager->persist($NewTransaction);
            $entityManager->flush();
            
        }

        /*--------------------------------------------- call of the template */
        
        return $this->render('add_transaction/index.html.twig', [
            'controller_name' => 'AddTransactionController',
            'form'=>$form->createView()
        ]);
    }
}
