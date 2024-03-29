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
if (isset($argc) == '' || isset($argv) == '') {
    print '    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
    print '<table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Result</th>
                  <th>Time</th>
                  <th>User</th>
                </tr>
              </thead>';
    foreach ($results as $result) {
        print '
              <tbody>
                <tr>
                  <th scope="row">' . $result->getId() . '</th>
                  <td>' . $result->getResult() . '</td>
                  <td>' . date_format($result->getTime(), 'g:ia \o\n l jS F Y') . '</td>
                  <td>'.$result->getUsers().'</td>
                </tr>
              </tbody>';
    }
    print '</table>';
}else{
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
}
