<?php // src/create_result.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new CreateResult($argc, $argv);
$script->run();

class CreateResult
{
    const USER_ID = 1;
    const RESULT = 2;

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Nuevo Registro:' . PHP_EOL;
        echo 'Para crear un nuevo registro ' . basename(__FILE__) . ' id_user registro' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 11223344' . PHP_EOL;
        exit;
    }


    private function create()
    {
        $user = new User();
        $id = $this->results[CreateResult::USER_ID];
        $result = $this->results[CreateResult::RESULT];
        $entityManager = getEntityManager();
        $user = $entityManager->getRepository(get_class($user))->findOneBy(array(User::ID => $id));

        if (is_null($user)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }

        $result = new Result(new \DateTime(), $user, $result);
        $entityManager->persist($result);
        $entityManager->flush();

        return $result;
    }


    public function run()
    {
        if ($this->atributte < 3|| $this->atributte >= 4) {
            $this->information();
            exit;
        }

        echo $this->create();
    }
}