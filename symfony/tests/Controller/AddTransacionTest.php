<?php
    namespace App\Test\Controller;

    use Symfony\Component\Panther\PantherTestCase;
    class AddTransactionTest extends PantherTestCase
    {
        public function AddTransaction() {
            $client = static::createPantherClient();
            $crawler = $client->request("GET", "/add");
            $form = $crawler->selectButton("Ajouter")->form([
                "Name" => "Bitcoin",
                "Quantité"=> 0.1,
                "Prix d'achat"=> 100
            ]);
            $client->submit($form);
            $this->assertSelectorTextContains("div.alert.alert-success", "Le produit a été créé avec succès !");
        }
    }
?>