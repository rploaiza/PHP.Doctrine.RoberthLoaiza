<?php // src/update_result.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new UpdateResult($argc, $argv);
$script->run();

class UpdateResult
{
    const ID = 1;
    const RESULT = 2;

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Editar Usuario:' . PHP_EOL;
        echo 'Para editar un usuario ' . basename(__FILE__) . ' id usuario email estado contraseña' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 rploaiza pauloaiza@hotmail.es 0 1234567' . PHP_EOL;
        echo 'Recuerda que el estado puede ser solo entre 0(inactivo) o 1(activo)';
        exit;
    }

    private function update()
    {

        $id = intval($this->results[UpdateResult::ID]);
        $entityManager = getEntityManager();
        $result = $entityManager->getRepository(Result::class)->findOneBy(array(Result::ID=> $id));

        if (is_null($result)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }

        $result->setResult($this->results[UpdateResult::RESULT]);
        $result->setTime(new \DateTime());

        $entityManager->merge($result);
        $entityManager->flush();

        return $result;
    }


    public function run()
    {
        if ($this->atributte < 3 || $this->atributte >= 4) {
            $this->information();
            exit;
        }

        echo $this->update();
    }
}
