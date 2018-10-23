<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Client;

class ClientTest extends TestCase
{
    public function testImpactBySurvey()
    {
        $client = (new Client)->setCpf('12345678901');
        $client->impactBySurvey();
        
        $this->assertSame(date('Y-m-d'), $client->getLastSurveyDate());
    }
}
