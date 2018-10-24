<?php

namespace App\Infra;

use App\Domain\Client;
use App\Domain\ClientRepositoryInterface;

class ClientDbRepository implements ClientRepositoryInterface
{
    public function createQuarantine(Client $client)
    {
        $pdo = new \PDO('mysql:dbname=nps;host=mysql', 'root', 'root');
        $sql = 'insert into quarantine(cpf, date) values(:cpf, now())';

        $stmt = $pdo->prepare($sql);
        $stmt->execute([':cpf' => $client->getCpf()]);
    }
}
