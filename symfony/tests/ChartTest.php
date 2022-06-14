<?php
namespace Tests\Util;

use PHPUnit\Framework\TestCase;
use App\Util\chartValue;


class ChartTest extends TestCase {
    public function testChart() {
        $ChartValue = new ChartValue();
        $resultat = $ChartValue->chart("BTC");
        $this->assertEquals("https://api.cryptowat.ch/markets/kraken/btceur/ohlc?periods=60", $resultat);
    }
}

?>