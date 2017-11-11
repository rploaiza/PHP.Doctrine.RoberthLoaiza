<?php // src/delete_result.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new DeleteResult($argc, $argv);
$script->run();

class DeleteResult
{
    const ID = 1;

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Eliminar Registro:' . PHP_EOL;
        echo 'Para eliminar un registro ' . basename(__FILE__) . ' id_registro' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1' . PHP_EOL;
        exit;
    }


    private function delete()
    {

        $id = $this->results[DeleteResult::ID];
        $entityManager = getEntityManager();
        $result = $entityManager->getRepository(Result::__CLASS__)->findOneBy(array(Result::ID => $id));

        if (is_null($result)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }

        $id = $result->getId();
        $entityManager->remove($result);
        $entityManager->flush();
        $result->setId($id);

        return $result;
    }


    public function run()
    {
        if ($this->atributte < 2|| $this->atributte >= 3) {
            $this->information();
            exit;
        }

        echo $this->delete();
    }
}