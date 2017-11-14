<?php // src/delete_result.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

if (isset($argc) == '' || isset($argv) == '') {


    $entityManager = getEntityManager();
    $result = $entityManager->getRepository(Result::__CLASS__)->findOneBy(array(Result::ID => $_GET['id']));

    if (is_null($result)) {
        print '<script language="javascript">';
        print 'alert("No existe id:' . $_GET['id'] . '");';
        print ' window.location.href = "../../web/result.html";';
        print '</script>';
    }

    $id = $result->getId();
    $entityManager->remove($result);
    $entityManager->flush();
    $result->setId($id);
    print '<script language="javascript">';
    print 'alert("Eliminado Correctamente");';
    print ' window.location.href = "../../web/result.html";';
    print '</script>';
} else {
    $script = new DeleteResult($argc, $argv);
    $script->run();
}


class DeleteResult
{
    const ID = 1;
    const JSON = '--json';

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Eliminar Resultado:' . PHP_EOL;
        echo 'Para eliminar un registro ' . basename(__FILE__) . ' [id_registro]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1  --json' . PHP_EOL;
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

    private function toResultado($result)
    {

        if (in_array(DeleteResult::JSON, $this->results, true))
            echo json_encode($result->jsonSerialize());
        else
            echo $result;

    }


    public function run()
    {
        if ($this->atributte < 2 || $this->atributte >= 4) {
            $this->information();
            exit;
        }

        $this->toResultado($this->delete());
    }
}