<?php

namespace App\Domain;

use Miti\Validacao;

class Client
{
    const QUANRANTINE_DAYS = 90;
    
    private $repo;

    private $cpf;
    private $lastSurveyDate;

    public function __construct(ClientRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function setCpf(string $cpf): Client
    {
        Validacao::cpf($cpf);
        $this->cpf = $cpf;
        
        return $this;
    }

    public function getCpf(): string
    {
        return $this->cpf;
    }

    public function getLastSurveyDate(): string
    {
        return $this->lastSurveyDate;
    }

    public function impactBySurvey(): Client
    {
        $this->checkQuarantine();
        $this->lastSurveyDate = date('Y-m-d');
        $this->repo->createQuarantine($this);
        
        return $this;
    }

    //todo: check repo instead
    private function checkQuarantine()
    {
        if ($this->lastSurveyDate === null) {
            return;
        }
        
        $lastSurveyDate = new \DateTime($this->lastSurveyDate);
        $today = new \DateTime('now');
        
        if ($lastSurveyDate->diff($today, true)->format('%a') < self::QUANRANTINE_DAYS) {
            throw new \Exception("The client {$this->cpf} is in survey quarantine");
        }
    }
}
