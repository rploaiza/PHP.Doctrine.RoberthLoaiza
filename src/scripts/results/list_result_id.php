<?php // src/list_result_id.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\Result;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

if (isset($argc) == '' || isset($argv) == '') {

    $entityManager = getEntityManager();
    $user = $entityManager->getRepository(Result::class)->findOneBy(array(Result::ID => $_GET['id']));
    if (empty($user) || $_GET['id'] == null) {
        print '<script language="javascript">';
        print 'alert("No existe id:' . $_GET['id'] . '");';
        print ' window.location.href = "../../web/result.html";';
        print '</script>';
    } else {
        print '<script language="javascript">';
        print 'alert("id:' . $user->getId() . ',  result:' . $user->getResult() . ',  Usuario:' . $user->getUsers() . '");';
        print ' window.location.href = "../../web/result.html";';
        print '</script>';
    }

} else {
    $script = new ListResultId($argc, $argv);
    $script->run();
}

class ListResultId
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
        echo 'Listar Resultado:' . PHP_EOL;
        echo 'Para listar un resultado ' . basename(__FILE__) . ' [id_resultado]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 ' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1  --json' . PHP_EOL;
        exit;
    }


    private function select()
    {

        $id = $this->results[ListResultId::ID];
        $entityManager = getEntityManager();
        $result = $entityManager->getRepository(Result::class)->findOneBy(array(Result::ID => $id));
        if (empty($result)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }

        return $result;
    }

    private function toResultado($result)
    {

        if (in_array(ListResultId::JSON, $this->results, true))
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

        $this->toResultado($this->select());
    }
}
