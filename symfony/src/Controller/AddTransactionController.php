<?php

namespace App\Controller;

use Doctrine\Persistence\ManagerRegistry;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Routing\Annotation\Route;

use App\Form\AddToWalletFormType;
use App\Entity\Wallet;
use App\Entity\Winnings;
use App\Repository\WinningsRepository;
use App\Repository\CurencyRepository;

class AddTransactionController extends AbstractController
{
    /**
     * @Route("/add", name="app_add_transaction")
     */    
    public function index(Request $request, ManagerRegistry $doctrine, WinningsRepository $winningRepository, CurencyRepository $curencyRepository): Response
    {
        $entityManager = $doctrine->getManager();

        $form = $this->createForm(AddToWalletFormType::class);
        $form->handleRequest($request);

        /*--------------------------------------------- Check validity of form */

        $allWinnings= $winningRepository->findAll();

        if($allWinnings===[]){
            $defaultwinnings = new Winnings;
            $defaultwinnings->setBalance(0);
            $defaultwinnings->setDateEntry(new \DateTime('@'.strtotime('now')));

            $entityManager->persist($defaultwinnings);
            $entityManager->flush($defaultwinnings);

            $balanceamount = 0;
        }else{
            $lastentires = end($allWinnings);
            $balanceamount = $lastentires->getBalance();
        }

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            
            /*--------------------------------------------- Adding forms data to DataBase */
            $currency = $curencyRepository->findOneBy([
                'Name' => $data['crypto_name']
            ]);

            $NewTransaction = new Wallet;
            $NewTransaction->setCurrency($currency);
            $NewTransaction->setAmount($data['amount']);
            $NewTransaction->setInitialValue($data['initial_value']);
            $NewTransaction->setCurrentValue($data['initial_value']);
            $NewTransaction->setStatus(true);
            $NewTransaction->setCreationDate(new \DateTime('@'.strtotime('now')));

            $newWinnings= new Winnings;
            $newWinnings->setBalance($balanceamount - $NewTransaction->getCurrentValue());
            $newWinnings->setDateEntry(new \DateTime('@'.strtotime('now')));

                
            $entityManager->persist($NewTransaction);
            $entityManager->flush();
            $entityManager->persist($newWinnings);
            $entityManager->flush($newWinnings);
        }

        /*--------------------------------------------- call of the template */
        
        return $this->render('add_transaction/index.html.twig', [
            'controller_name' => 'AddTransactionController',
            'form'=>$form->createView()
        ]);
    }
}
