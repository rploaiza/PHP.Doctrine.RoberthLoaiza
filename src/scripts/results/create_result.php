<?php // src/create_result.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

if (isset($argc)=='' || isset($argv)=='')  {
    $user = new User();
    $id = $_POST['id'];
    $result = $_POST['resultado'];
    $entityManager = getEntityManager();
    $user = $entityManager->getRepository(get_class($user))->findOneBy(array(User::ID => $id));

    if (is_null($user)) {
    print '<script language="javascript">';
    print 'alert("No existe id:' . $_POST['id'] . '");';
    print ' window.location.href = "../../web/result.html";';
    print '</script>';
}

    $result = new Result(new \DateTime(), $user, $result);
    $entityManager->persist($result);
    $entityManager->flush();
    print '<script language="javascript">';
    print 'alert("Almacenado Correctamente");';
    print ' window.location.href = "../../web/result.html";';
    print '</script>';
}else{
    $script = new CreateResult($argc, $argv);
    $script->run();
}


class CreateResult
{
    const USER_ID = 1;
    const RESULT = 2;
    const JSON = '--json';

    public function __construct($atributte, $results)
    {
        $this->atributte = $atributte;
        $this->results = $results;
    }


    private function information()
    {
        echo 'Nuevo Resultado:' . PHP_EOL;
        echo 'Para crear un nuevo registro ' . basename(__FILE__) . ' [id_user] [registro]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1  11223344' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1  11223344  --json' . PHP_EOL;
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

    private function toResultado($result){

        if (in_array(CreateResult::JSON, $this->results, true))
            echo json_encode($result->jsonSerialize());
        else
            echo $result;

    }


    public function run()
    {
        if ($this->atributte < 3|| $this->atributte >= 5) {
            $this->information();
            exit;
        }

        $this->toResultado($this->create());
    }
}