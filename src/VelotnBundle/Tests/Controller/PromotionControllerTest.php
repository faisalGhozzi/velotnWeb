<?php

namespace VelotnBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class PromotionControllerTest extends WebTestCase
{
    public function testPromotion()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/Promotion');
    }

}
