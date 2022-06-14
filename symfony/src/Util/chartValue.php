<?php
# src/Util/HelloWorld.php
namespace App\Util;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class chartValue {
    public function chart($name) {
        if( $name==="BTC"){
            $slug = "btceur";
            $market = "kraken";
        }elseif( $name==="ETH"){
            $slug = "etheur";
            $market = "kraken";
        }elseif( $name==="XPR"){
            $slug = "xprusdt";
            $market = "hitbtc";
        }else{
            return new RedirectResponse('http://crypto.mg-digital.fr');
        }

        $url= 'https://api.cryptowat.ch/markets/'.$market.'/'. $slug .'/ohlc?periods=60';

    
        return  $url;

    }
}

?>