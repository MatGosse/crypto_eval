<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use App\Form\RemoveWalletFormType;

use Doctrine\Persistence\ManagerRegistry;
use App\Repository\WalletRepository;
use App\Repository\WinningsRepository;

class ChartController extends AbstractController
{
    /**
     * @Route("/chart", name="app_chart")
     */
    public function index(Request $request, ManagerRegistry $doctrine, WalletRepository $walletRepository, HttpClientInterface $client): Response
    {
        $entityManager = $doctrine->getManager();

        $transaction = $walletRepository->find($request->query->getInt('id'));
        
        
        if($transaction===null || $transaction->getStatus()===false){
            return $this->redirectToRoute('app_default');
        }
        /*---------------------------------------------Check current Value*/
        
 
        if( $transaction->getCurrency()->getSlug()==="BTC"){
            $slug = "btceur";
        }
        $date = $transaction->getCreationDate()->getTimestamp();

        $url= 'https://api.cryptowat.ch/markets/kraken/'. $slug .'/ohlc?periods=60&after='.$date.'';
        
        /*call to api */
             
        $response = $client->request('GET', $url, [
            'headers' => [
                'Accept' => 'application/json',
                'X-CW-API-Key' => 'EFFU7UWMBJHKJIU4XTX9'
            ],
        ]);
        $content = $response->getContent(); 
        //$transaction->setCurrentValue(json_decode($content)->data[0]->quote->USD->price);   
        //$entityManager->flush($transaction);
         



        $data = $walletRepository->findAll();


        return $this->render('chart/index.html.twig', [
            'controller_name' => 'Gains',
            'data'=> json_decode($content)->result->{'60'},
            'amount'=> $transaction->getAmount(),
            'initial'=> $transaction->getAmount()/$transaction->getInitialAmount()*$transaction->getInitialValue()
        ]);
    }
}
