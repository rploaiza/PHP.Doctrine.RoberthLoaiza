<?php // src/list_result_id.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new ListResultId($argc, $argv);
$script->run();

class ListResultId
{
    const ID = 1;

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Listar Usuario:' . PHP_EOL;
        echo 'Para listar un resultado ' . basename(__FILE__) . ' id_resultado' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 ' . PHP_EOL;
        exit;
    }


    private function select()
    {

        $id = $this->results[ListResultId::ID];
        $entityManager = getEntityManager();
        $user = $entityManager->getRepository(Result::class)->findOneBy(array(Result::ID => $id));
        if (empty($user)) {
            echo 'El id:' . $id . ' no existe';
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
