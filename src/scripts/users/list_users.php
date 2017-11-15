<?php // src/scripts/list_users.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();


$entityManager = getEntityManager();

$userRepository = $entityManager->getRepository(User::class);
$users = $userRepository->findAll();
if (isset($argc) == '' || isset($argv) == '') {
    print '    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>';
    print '<table class="table table-striped">
              <thead>
                <tr>
                  <th>#</th>
                  <th>Usuario</th>
                  <th>Email</th>
                  <th>Password</th>
                  <th>Enabled</th>
                  <th>Date</th>
                  <th>Token</th>
                </tr>
              </thead>';
    foreach ($users as $user) {
        if($user->isEnabled()==false){
            $user->setEnabled('No');
        }else
            $user->setEnabled('Si');
        print '
              <tbody>
                <tr>
                  <th scope="row">' . $user->getId() . '</th>
                  <td>' . $user->getUsername() . '</td>
                  <td>' . $user->getEmail() . '</td>
                  <td>' . $user->getPassword() . '</td>
                  <td>' . $user->isEnabled(). '</td>
                  <td>' . date_format($user->getLastLogin(), 'g:ia \o\n l jS F Y') . '</td>
                  <td>' . $user->getToken() . '</td>
                </tr>
              </tbody>';
    }
    print '</table>';
} else {
    if (in_array('--json', $argv)) {
        echo json_encode($users, JSON_PRETTY_PRINT);
    } else {
        $items = 0;
        echo PHP_EOL . sprintf("  %2s: %15s %25s %10s %7s %15s %40s\n", 'Id', 'Username:', 'Email:', 'Password:', 'Enabled:', 'Time:', 'Token:');
        /** @var User $user */
        foreach ($users as $user) {
            echo sprintf(
                '- %2d: %15s %25s %10s %7s %20s %40s',
                $user->getId(),
                $user->getUsername(),
                $user->getEmail(),
                $user->getPassword(),
                ($user->isEnabled()) ? 'true' : 'false',
                date_format($user->getLastLogin(), 'g:ia \o\n l jS F Y'),
                $user->getToken()
            ),
            PHP_EOL;
            $items++;
        }

        echo "\nTotal: $items users.\n\n";
    }
}




