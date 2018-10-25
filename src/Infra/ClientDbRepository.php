<?php

namespace App\Infra;

use App\Domain\Client;
use App\Domain\ClientRepositoryInterface;

class ClientDbRepository implements ClientRepositoryInterface
{
    private $pdo;
    
    public function __construct()
    {
        $this->pdo = new \PDO('mysql:dbname=nps;host=mysql', 'root', 'root');
    }

    public function createQuarantine(Client $client)
    {
        $sql = 'insert into quarantine(cpf, date) values(:cpf, :date)';
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            ':cpf' => $client->getCpf(),
            ':date' => $client->getLastSurveyDate(),
        ]);
    }
    
    public function findLastQuarantineDate(Client $client)
    {
        $sql = 'select date from quarantine where cpf = :cpf order by date desc';
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute(['cpf' => $client->getCpf()]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        
        return $result['date'];
    }
}
