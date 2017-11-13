<?php // src/create_user.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

$script = new CreateUser($argc, $argv);
$script->run();

class CreateUser
{
    const USERNAME = 1;
    const EMAIL = 2;
    const PASSWORD = 3;
    const JSON = '--json';

    public function __construct($atributte, $users)
    {
        $this->atributte = $atributte;
        $this->users = $users;
    }

    private function information()
    {
        echo 'Nuevo Usuario:' . PHP_EOL;
        echo 'Para crear un nuevo usuario ' . basename(__FILE__) . ' [usuario] [email] [contraseña]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  rploaiza  pauloaiza@hotmail.es  1234567' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  rploaiza  pauloaiza@hotmail.es  1234567  --json' . PHP_EOL;
        exit;
    }

    private function token($code)
    {
        $key = '';
        $pattern = '1234567890AbCdEfGhIjKlMnOpQrStUvWxYz';
        $max = strlen($pattern) - 1;
        for ($i = 0; $i < $code; $i++) $key .= $pattern{mt_rand(0, $max)};
        return $key;
    }

    private function create()
    {
        $user = new User();
        $user->setUsername($this->users[CreateUser::USERNAME]);
        $user->setEmail($this->users[CreateUser::EMAIL]);
        $user->setEnabled(true);
        $user->setPassword($this->users[CreateUser::PASSWORD]);
        $user->setLastLogin(new \DateTime());
        $user->setToken($this->token(40));
        $entityManager = getEntityManager();
        $users = $entityManager->getRepository(User::class)->findBy(array(User::EMAIL => $user->getEmail()));

        if (!empty($users)) {
            echo 'Usuario con el email:' . $user->getEmail() . ' ya existe';
            exit;
        }

        $entityManager->persist($user);
        $entityManager->flush();
        return $user;
    }

    private function toResultado($user){

        if (in_array(CreateUser::JSON, $this->users, true))
            echo json_encode($user->jsonSerialize());
        else
            echo $user;

    }


    public function run()
    {
        if ($this->atributte < 4 || $this->atributte >= 6) {
            $this->information();
            exit;
        }

        $this->toResultado($this->create());
    }
}
