<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\WalletRepository;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Doctrine\Persistence\ManagerRegistry;


class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="app_default")
     */
    public function index(ManagerRegistry $doctrine, WalletRepository $walletRepository, HttpClientInterface $client): Response
    {
        $entityManager = $doctrine->getManager();

        /*--------------------------------------------- get all data transactions*/
        
        $data = $walletRepository->findByStatusWallet([true]);
        
        foreach ($data as $trade){

            /*---------------------------------------------Check current Value*/

            $amount = $trade->getAmount();
            $slug = $trade->getCurrency()->getSlug();
            $url= 'https://pro-api.coinmarketcap.com/v2/tools/price-conversion?symbol='.$slug.'&amount='.$amount.'';
    
            /*call to api */
            
            $response = $client->request('GET', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'X-CMC_PRO_API_KEY' => '073c15a6-fd76-40d2-8efd-9a62ecab8077'
                ],
            ]);
            $content = $response->getContent(); 
            $trade->setCurrentValue(json_decode($content)->data[0]->quote->USD->price);   

            $entityManager->flush($trade);
        }

        /*--------------------------------------------- call of the template*/

        return $this->render('default/index.html.twig', [
            'controller_name' => 'Crypto Tracker',
            'data_wallet'=> $data
        ]);
    }
}
