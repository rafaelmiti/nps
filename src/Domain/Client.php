<?php

namespace App\Domain;

use Miti\Validacao;

class Client
{
    const QUARANTINE_DAYS = 90;
    
    private $repo;

    private $cpf;
    private $lastSurveyDate;

    public function __construct(string $cpf, ClientRepositoryInterface $repo)
    {
        Validacao::cpf($cpf);
        $this->cpf = $cpf;
        
        $this->repo = $repo;
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

    private function checkQuarantine()
    {
        $lastQuarantineDateString = $this->repo->findLastQuarantineDate($this);
        
        if (!$lastQuarantineDateString) {
            return;
        }
        
        $lastQuarantineDate = new \DateTime($lastQuarantineDateString);
        $today = new \DateTime('now');
        
        if ($lastQuarantineDate->diff($today, true)->format('%a') < self::QUARANTINE_DAYS) {
            throw new \Exception("The client {$this->cpf} is in survey quarantine");
        }
    }
}
