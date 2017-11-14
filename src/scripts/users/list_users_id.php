<?php // src/list_users_id.php

require __DIR__ . '/../../../vendor/autoload.php';
require_once __DIR__ . '/../../../bootstrap.php';

use MiW\Results\Entity\User;

// Carga las variables de entorno
$dotenv = new \Dotenv\Dotenv(__DIR__ . '/../../..');
$dotenv->load();

if (isset($argc) == '' || isset($argv) == '') {

    $entityManager = getEntityManager();
    $user = $entityManager->getRepository(User::class)->findOneBy(array(User::ID => $_GET['id']));
    if (empty($user) || $_GET['id'] == null) {
        print '<script language="javascript">';
        print 'alert("No existe id:' . $_GET['id'] . '");';
        print ' window.location.href = "../../web/index.html";';
        print '</script>';
    } else {
        if ($user->isEnabled() == false) {
            $user->setEnabled('No');
        } else
            $user->setEnabled('Si');
        print '<script language="javascript">';
        print 'alert("id:' . $user->getId() . ',  username:' . $user->getUsername() . ',  email:' . $user->getEmail() . ',  enabled:' . $user->isEnabled() . ',  password:' . $user->getPassword() . ',  lastLogin:' . date_format($user->getLastLogin(), 'g:ia \o\n l jS F Y') . ',  token:' . $user->getToken() . '");';
        print ' window.location.href = "../../web/index.html";';
        print '</script>';
    }
} else {
    $script = new ListUserId($argc, $argv);
    $script->run();
}


class ListUserId
{
    const ID = 1;
    const JSON = '--json';

    public function __construct($atributte, $users)
    {
        $this->atributte = $atributte;
        $this->users = $users;
    }


    private function information()
    {
        echo 'Listar Usuario:' . PHP_EOL;
        echo 'Para listar un usuario ' . basename(__FILE__) . ' [id_usuario]' . PHP_EOL . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1 ' . PHP_EOL . PHP_EOL;
        echo '--json > Otro formato de visualización ' . PHP_EOL;
        echo 'Ejemplo: ' . basename(__FILE__) . '  1   --json' . PHP_EOL;
        exit;
    }


    private function select()
    {
        $id = $this->users[ListUserId::ID];
        $entityManager = getEntityManager();
        $user = $entityManager->getRepository(User::class)->findOneBy(array(User::ID => $id));
        if (empty($user)) {
            echo 'El id:' . $id . ' no existe';
            exit;
        }
        return $user;
    }

    private function toResultado($user)
    {

        if (in_array(ListUserId::JSON, $this->users, true))
            echo json_encode($user->jsonSerialize());
        else
            echo $user;

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
