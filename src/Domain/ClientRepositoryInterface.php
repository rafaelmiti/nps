<?php

namespace App\Domain;

interface ClientRepositoryInterface
{
    public function createQuarantine(Client $client);
}
