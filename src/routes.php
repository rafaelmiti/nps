<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Infra\ClientDbRepository;
use App\Domain\Client;

$app->post('/clients/{cpf}/survey', function (Request $request, Response $response, array $args) {
    try {
        $repo = new ClientDbRepository;
        $client = (new Client($repo))->setCpf($args['cpf'])->impactBySurvey();

        return $response->withJson([
            'cpf' => $client->getCpf(),
            'last_survey_date' => $client->getLastSurveyDate(),
        ]);
    } catch (\Exception $e) {
        return $response->withJson(['error' => $e->getMessage()]);
    }
});
