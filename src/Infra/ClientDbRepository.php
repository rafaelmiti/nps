<?php

namespace App\Infra;

use App\Domain\Client;
use App\Domain\ClientRepositoryInterface;

class ClientDbRepository implements ClientRepositoryInterface
{
    const NINETY_DAYS_IN_SECONDS = 7776000;
    
    private $cache;
    private $pdo;
    
    public function __construct()
    {
        $this->cache = (new \Memcached);
        $this->cache->addServer('memcached', 11211);
    }

    public function connectToDb()
    {
        $this->pdo = new \PDO('mysql:dbname=nps;host=mysql', 'root', 'root');
    }

    public function createQuarantine(Client $client)
    {
        $this->createQuarantineInCache($client);
        $this->createQuarantineInDb($client);
    }
    
    private function createQuarantineInCache(Client $client)
    {
        try {
            $this->cache->set(
                $client->getCpf(),
                ['date' => $client->getLastSurveyDate()],
                time() + self::NINETY_DAYS_IN_SECONDS
            );
        } finally {
            $this->cache->quit();
        }
    }
    
    public function createQuarantineInDb(Client $client)
    {
        try {
            $this->connectToDb();

            $sql = 'insert into quarantine(cpf, date) values(:cpf, :date)';
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute([
                ':cpf' => $client->getCpf(),
                ':date' => $client->getLastSurveyDate(),
            ]);
        } finally {
            $this->pdo = null;
        }
    }

    public function findLastQuarantineDate(Client $client)
    {
        $cachedDate = $this->findLastQuarantineDateInCache($client);
        
        if ($cachedDate) {
            return $cachedDate['date'];
        }
        
        return $this->findLastQuarantineDateInDb($client);
    }
    
    public function findLastQuarantineDateInCache(Client $client)
    {
        try {
            return $this->cache->get($client->getCpf());
        } finally {
            $this->cache->quit();
        }
    }
    
    public function findLastQuarantineDateInDb(Client $client)
    {
        try {
            $this->connectToDb();

            $sql = 'select date from quarantine where cpf = :cpf order by date desc';
            $stmt = $this->pdo->prepare($sql);

            $stmt->execute(['cpf' => $client->getCpf()]);
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            return $result['date'];
        } finally {
            $this->pdo = null;
        }
    }
}
