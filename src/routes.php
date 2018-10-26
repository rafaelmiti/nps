<?php

use Slim\Http\Request;
use Slim\Http\Response;

use App\Infra\ClientDbRepository;
use App\Domain\Client;

$app->post('/clients/{cpf}/survey', function (Request $request, Response $response, array $args) {
    try {
        $repo = new ClientDbRepository;
        $client = (new Client($args['cpf'], $repo))->impactBySurvey();

        return $response->withJson([
            'cpf' => $client->getCpf(),
            'last_survey_date' => $client->getLastSurveyDate(),
        ]);
    } catch (\BadMethodCallException $e) {
        return $response->withStatus(400)->withJson(['error' => $e->getMessage()]);
    } catch (\Exception $e) {
        return $response->withStatus(500)->withJson(['error' => $e->getMessage()]);
    }
});
