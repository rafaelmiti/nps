<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Infra\ClientMemoryRepository;
use App\Domain\Client;

$app->post('/clients/{cpf}/survey', function (Request $request, Response $response, array $args) {
    $repo = new ClientMemoryRepository;
    $client = (new Client($repo))->setCpf($args['cpf'])->impactBySurvey();

    return $response->withJson([
        'cpf' => $client->getCpf(),
        'last_survey_date' => $client->getLastSurveyDate(),
    ]);
});
