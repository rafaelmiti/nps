<?php

namespace App\Infra;

use App\Domain\Client;
use App\Domain\ClientRepositoryInterface;

class ClientMemoryRepository implements ClientRepositoryInterface
{
    private $impacts = [];
    
    public function createImpact(Client $client)
    {
        $this->impacts[] = ['cpf' => $client->getCpf(), 'date' => $client->getLastSurveyDate()];
    }
}
