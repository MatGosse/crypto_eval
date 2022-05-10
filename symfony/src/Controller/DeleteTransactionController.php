<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WalletRepository;
use Symfony\Component\HttpFoundation\Request;
use App\Form\RemoveWalletFormType;
use Doctrine\Persistence\ManagerRegistry;


class DeleteTransactionController extends AbstractController
{
    /**
     * @Route("/delete", name="app_delete_transaction")
     */
    public function index(Request $request, WalletRepository $walletRepository, ManagerRegistry $doctrine): Response
    {
        /*--------------------------------------------- check the statue of the transaction*/
        
        $transaction = $walletRepository->find($request->query->getInt('id'));
        if($transaction->getStatus()===false){
            return $this->redirectToRoute('app_default');
        }
        /*--------------------------------------------- create form */

        $form = $this->createForm(RemoveWalletFormType::class);
        $form->handleRequest($request);

        /*--------------------------------------------- check valdity of form */

        if($form->isSubmitted() && $form->isValid()){
            $data=$form->getData();
            $entityManager = $doctrine->getManager();

            if($transaction->getAmount() > (int)$data['amount']){
                $transaction->setAmount( (int)$data['amount']);
                
                return $this->redirectToRoute('app_default');
            }else if($transaction->getAmount()=== (int)$data['amount']){
                $transaction->setAmount(0);
                $transaction->setStatus(false);
                
                return $this->redirectToRoute('app_default');
            }else{
                /*error value can't be negative*/
            }
            
            /*--------------------------------------------- update data */
            
            $entityManager->persist($transaction);
            $entityManager->flush($transaction); 

        }
        /*--------------------------------------------- call of the template*/

        return $this->render('delete_transaction/index.html.twig', [
            'controller_name' => $transaction->getAmount(),
            'form'=>$form->createView()
        ]);
       
    }
}
