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
        $this->validateCpf($cpf);
        $this->cpf = $cpf;
        
        $this->repo = $repo;
    }

    private function validateCpf(string $cpf)
    {
        try {
            Validacao::cpf($cpf);
        } catch (\Exception $e) {
            throw new \BadMethodCallException($e->getMessage());
        }
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
            throw new \BadMethodCallException("The client {$this->cpf} is in survey quarantine");
        }
    }
}
