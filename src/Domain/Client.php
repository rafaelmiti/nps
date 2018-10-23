<?php

namespace App\Domain;

class Client
{
    private $cpf;
    private $lastSurveyDate;

    public function setCpf(string $cpf): Client
    {
        $this->cpf = $cpf;
        return $this;
    }

    public function getLastSurveyDate(): string
    {
        return $this->lastSurveyDate;
    }

    public function impactBySurvey()
    {
        $this->lastSurveyDate = date('Y-m-d');
    }
}
