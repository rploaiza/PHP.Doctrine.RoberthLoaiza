<?php // src/delete_user.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new DeleteUser($argc, $argv);
$script->run();

class DeleteUser
{
    const ID = 1;

    public function __construct($atributte, $users)
    {
        $this->atributte = $atributte;
        $this->users = $users;
    }

    private function informacion()
    {
        echo 'Eliminar Usuario:' . PHP_EOL;
        echo 'Para eliminar un usuario ' . basename(__FILE__) . ' id_usuario ' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . ' 1 ' . PHP_EOL;
        exit;
    }

    private function delete()
    {
        $entityManager = getEntityManager();
        $id = $this->users[DeleteUser::ID];
        $user = $entityManager->getRepository(User::__CLASS__)->findOneBy(array(User::ID => $id));

        if (is_null($user)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }

        $results = $entityManager->getRepository(Result::__CLASS__)->findBy(array(Result::USER => $user));

        foreach ($results as $result)
            $entityManager->remove($result);
        $id = $user->getId();
        $entityManager->remove($user);
        $entityManager->flush();
        $user->setId($id);

        return $user;
    }


    public function run()
    {
        if ($this->atributte < 2 || $this->atributte >= 3) {
            $this->informacion();
            exit;
        }

        echo $this->delete();
    }
}