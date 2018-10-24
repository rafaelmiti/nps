<?php

use PHPUnit\Framework\TestCase;
use App\Domain\Client;
use App\Infra\ClientMemoryRepository;

class ClientTest extends TestCase
{
    public function testImpactBySurvey()
    {
        $repo = new ClientMemoryRepository;
        $client = (new Client($repo))->setCpf('97238691019')->impactBySurvey();
        
        $this->assertSame(date('Y-m-d'), $client->getLastSurveyDate());
    }
    
    public function testImpactBySurveyInQuarantine()
    {
        $cpf = '97238691019';
        
        $repo = new ClientMemoryRepository;
        $client = (new Client($repo))->setCpf($cpf)->impactBySurvey();
        
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage("The client $cpf is in survey quarantine");
        
        $client->impactBySurvey();
    }
}
