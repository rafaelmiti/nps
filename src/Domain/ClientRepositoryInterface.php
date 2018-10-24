<?php

namespace App\Domain;

interface ClientRepositoryInterface
{
    public function createImpact(Client $client);
}
