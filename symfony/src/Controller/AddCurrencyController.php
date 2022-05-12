<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Images;
use App\Form\AddCurrencyType;
use App\Entity\Curency;
use Symfony\Component\HttpFoundation\Request;

use Doctrine\Persistence\ManagerRegistry;

class AddCurrencyController extends AbstractController
{
    /**
     * @Route("/addcurrency", name="app_add_currency")
     */
    public function index(Request $request, ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        
        $currency = new Curency;

        $form= $this->createForm(AddCurrencyType::class, $currency);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {

            // On récupère les images transmises
            $images = $form->get('images')->getData();
            
            // On boucle sur les images
            foreach($images as $image){
                // On génère un nouveau nom de fichier
                $fichier = md5(uniqid()).'.'.$image->guessExtension();
                
                // On copie le fichier dans le dossier uploads
                $image->move(
                    $this->getParameter('images_directory'),
                    $fichier
                );
                
                // On crée l'image dans la base de données
                $img = new Images;
                $img->setName($fichier);
                $currency->setImages($img);

            }
        
            $entityManager->persist($currency);
            $entityManager->flush();
        
        }

        return $this->render('add_currency/index.html.twig', [
            'controller_name' => 'AddCurrencyController',
            'form'=>$form->createView()
        ]);
    }
}
