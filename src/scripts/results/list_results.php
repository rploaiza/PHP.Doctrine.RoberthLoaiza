<?php   // src/list_results.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\Result;


// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

$entityManager = getEntityManager();

$resultsRepository = $entityManager->getRepository(Result::class);
$results = $resultsRepository->findAll();

if ($argc === 1) {
    echo PHP_EOL . sprintf('%10s  %10s  %20s  %20s', 'Id:', 'result: ', 'time:', 'user:') . PHP_EOL;
    $items = 0;
    /* @var Result $result */
    foreach ($results as $result) {
        echo $result . PHP_EOL;
        $items++;
    }
    echo PHP_EOL . "Total: $items results.";
} elseif (in_array('--json', $argv, true)) {
    echo json_encode($results, JSON_PRETTY_PRINT);
}
