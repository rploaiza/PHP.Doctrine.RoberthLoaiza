<?php // src/list_users_id.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new ListUserId($argc, $argv);
$script->run();

class ListUserId
{
    const ID = 1;

    public function __construct($atributte, $users)
    {
        $this->atributte = $atributte;
        $this->users = $users;
    }


    private function information()
    {
        echo 'Listar Usuario:' . PHP_EOL;
        echo 'Para listar un usuario ' . basename(__FILE__) . ' id_usuario' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 ' . PHP_EOL;
        exit;
    }


    private function select()
    {
        $filterArgument = $this->users[ListUserId::ID];
        $entityManager = getEntityManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(array(User::ID => $filterArgument));
        if (empty($user)) {
            echo 'El id:' . $filterArgument . ' no existe';
            exit;
        }
        return $user;
    }


    public function run()
    {
        if ($this->atributte < 2 || $this->atributte >= 3) {
            $this->information();
            exit;
        }

        echo $this->select();
    }
}
