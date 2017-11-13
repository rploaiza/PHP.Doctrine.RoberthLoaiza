<?php // src/update_result.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

$script = new UpdateResult($argc, $argv);
$script->run();

class UpdateResult
{
    const ID = 1;
    const RESULT = 2;
    const JSON = '--json';

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Editar Resultado:' . PHP_EOL;
        echo 'Para editar un resultado ' . basename(__FILE__) . ' [id_result] [result]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1  21234567' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1  21234567  --json' . PHP_EOL . PHP_EOL;
        echo 'Recuerda que el estado puede ser solo entre 0(inactivo) o 1(activo)'.PHP_EOL;
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

    private function toResultado($result){

        if (in_array(UpdateResult::JSON, $this->results, true))
            echo json_encode($result->jsonSerialize());
        else
            echo $result;

    }


    public function run()
    {
        if ($this->atributte < 3 || $this->atributte >= 5) {
            $this->information();
            exit;
        }

        $this->toResultado($this->update());
    }
}
