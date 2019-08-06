<?php

namespace App;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../src/Generator.php';

$companies = Generator::generate(100);

$configuration = [
    'settings' => [
        'displayErrorDetails' => true,
    ],
];

$app = new \Slim\App($configuration);

$app->get('/', function ($request, $response) use ($companies) {
    return $response->write('go to the /companies');
});

$app->get('/companies', function ($request, $response) use ($companies) {
    $page = $request->getQueryParam('page', 1);
    $per = $request->getQueryParam('per', 5);

    $filteredCompanies = array_slice($companies, ($page - 1) * $per, $per);
    return $response->write(json_encode($filteredCompanies));
});

$app->run();