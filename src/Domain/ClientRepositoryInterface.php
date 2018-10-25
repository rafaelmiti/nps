<?php

namespace App\Domain;

interface ClientRepositoryInterface
{
    public function createQuarantine(Client $client);
    public function findLastQuarantineDate(Client $client);
}
