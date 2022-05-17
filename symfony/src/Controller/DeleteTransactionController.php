<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Entity\Winnings;

use App\Form\RemoveWalletFormType;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\WalletRepository;
use App\Repository\WinningsRepository;

class DeleteTransactionController extends AbstractController
{
    /**
     * @Route("/delete", name="app_delete_transaction")
     */
    public function index(Request $request, HttpClientInterface $client, WalletRepository $walletRepository, WinningsRepository $winningRepository, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        /*--------------------------------------------- check the statue of the transaction*/
        
        $transaction = $walletRepository->find($request->query->getInt('id'));
        if($transaction===null || $transaction->getStatus()===false){
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
                
                /*---------------------------------------------Check current Value*/
                
                $amount = $transaction->getAmount();
                $slug = $transaction->getCurrency()->getSlug();
                $url= 'https://pro-api.coinmarketcap.com/v2/tools/price-conversion?symbol='.$slug.'&amount='.$amount.'';
                
                /*call to api */
                
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-CMC_PRO_API_KEY' => '073c15a6-fd76-40d2-8efd-9a62ecab8077'
                    ],
                ]);
                $content = $response->getContent();
              
                $transaction->setCurrentValue(json_decode($content)->data[0]->quote->USD->price);
                
                /*---------------------------------------------Set Value*/

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

                /*---------------------------------------------Check current Value*/
                
                $amount = $transaction->getAmount();
                $slug = $transaction->getCurrency()->getSlug();
                $url= 'https://pro-api.coinmarketcap.com/v2/tools/price-conversion?symbol='.$slug.'&amount='.$amount.'';
                
                /*call to api */
                
                $response = $client->request('GET', $url, [
                    'headers' => [
                        'Accept' => 'application/json',
                        'X-CMC_PRO_API_KEY' => '073c15a6-fd76-40d2-8efd-9a62ecab8077'
                    ],
                ]);
                $content = $response->getContent();
              
                $transaction->setCurrentValue(json_decode($content)->data[0]->quote->USD->price);
                
                /*---------------------------------------------Set Value*/

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
                        
        }
        /*--------------------------------------------- call of the template*/

        return $this->render('delete_transaction/index.html.twig', [
            'controller_name' => $transaction->getAmount(),
            'form'=>$form->createView()
        ]);
       
    }
}
