<?php // src/update_user.php

require __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../bootstrap.php';

use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../..');
$dotenv->load();

$script = new UpdateUser($argc, $argv);
$script->run();

class UpdateUser
{
    const ID = 1;
    const USERNAME = 2;
    const EMAIL = 3;
    const ENABLED = 4;
    const PASSWORD = 5;

    public function __construct($atributte, $users)
    {
        $this->atributte = $atributte;
        $this->users = $users;
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
        $userID = intval($this->users[UpdateUser::ID]);
        $entityManager = getEntityManager();
        $user =  $entityManager->getRepository(User::class)->findOneBy(array(User::ID => $userID));

        if (is_null($user)) {
            echo 'El id:' . $userID . ' no existe';
            exit;
        }

        $user->setUsername($this->users[UpdateUser::USERNAME]);
        $user->setEmail($this->users[UpdateUser::EMAIL]);
        if ($this->users[UpdateUser::ENABLED] == 1 || $this->users[UpdateUser::ENABLED] == 0)
            $user->setEnabled($this->users[UpdateUser::ENABLED]);
        else
            echo 'estado puede ser solo entre 0(inactivo) o 1(activo)'.PHP_EOL;
        $user->setPassword($this->users[UpdateUser::PASSWORD]);
        $user->setLastLogin(new \DateTime());
        $entityManager->merge($user);
        $entityManager->flush();

        return $user;
    }


    public function run()
    {
        if ($this->atributte < 6 || $this->atributte >= 7) {
            $this->information();
            exit;
        }

        echo $this->update();
    }
}
