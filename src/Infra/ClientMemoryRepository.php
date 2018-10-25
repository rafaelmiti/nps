<?php

namespace App\Infra;

use App\Domain\Client;
use App\Domain\ClientRepositoryInterface;

class ClientMemoryRepository implements ClientRepositoryInterface
{
    private $quarantines = [];
    
    public function createQuarantine(Client $client)
    {
        $this->quarantines[] = [
            'cpf' => $client->getCpf(),
            'date' => $client->getLastSurveyDate()
        ];
    }
    
    public function findLastQuarantineDate(Client $client)
    {
        $lastQuarantineDate = null;
        
        foreach ($this->quarantines as $quarantine) {
            if ($quarantine['cpf'] == $client->getCpf()) {
                $lastQuarantineDate = $quarantine['date'];
            }
        }
        
        return $lastQuarantineDate;
    }
}
