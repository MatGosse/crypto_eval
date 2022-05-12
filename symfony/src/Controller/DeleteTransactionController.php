<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WalletRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RemoveWalletFormType;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\WinningsRepository;
use App\Entity\Winnings;


class DeleteTransactionController extends AbstractController
{
    /**
     * @Route("/delete", name="app_delete_transaction")
     */
    public function index(Request $request, WalletRepository $walletRepository, WinningsRepository $winningRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        /*--------------------------------------------- check the statue of the transaction*/
        
        $transaction = $walletRepository->find($request->query->getInt('id'));
        if($transaction->getStatus()===false){
            return $this->redirectToRoute('app_default');
        }
        /*--------------------------------------------- create form */

        $form = $this->createForm(RemoveWalletFormType::class);
        $form->handleRequest($request);

        /*--------------------------------------------- check winnigs list */
        
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

        /*--------------------------------------------- check valdity of form */

        if($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();

            if($transaction->getAmount() > (int)$data['amount']){
                $transaction->setAmount( (int)$data['amount']);
                
                $newWinnings= new Winnings;
                $newWinnings->setBalance($balanceamount + $transaction->getCurrentValue());
                $newWinnings->setDateEntry(new \DateTime('@'.strtotime('now')));

                $entityManager->persist($transaction);
                $entityManager->flush($transaction); 
                $entityManager->persist($newWinnings);
                $entityManager->flush($newWinnings);
                return $this->redirectToRoute('app_default');
            }else if($transaction->getAmount()=== (int)$data['amount']){
                $transaction->setAmount(0);
                $transaction->setStatus(false);
                
                $newWinnings= new Winnings;
                $newWinnings->setBalance($balanceamount + $transaction->getCurrentValue());  
                $newWinnings->setDateEntry(new \DateTime('@'.strtotime('now')));

                $entityManager->persist($transaction);
                $entityManager->flush($transaction); 
                $entityManager->persist($newWinnings);
                $entityManager->flush($newWinnings);
                return $this->redirectToRoute('app_default');
            }else{
                /*to do error value can't be negative*/
            }
            
            /*--------------------------------------------- update data */
            
        }
        /*--------------------------------------------- call of the template*/

        return $this->render('delete_transaction/index.html.twig', [
            'controller_name' => $transaction->getAmount(),
            'form'=>$form->createView()
        ]);
       
    }
}
