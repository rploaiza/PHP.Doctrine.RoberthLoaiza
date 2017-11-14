<?php   // tests/Entity/UserTest.php

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\User;
use PHPUnit\Framework\TestCase;

/**
 * Class UserTest
 *
 * @package MiW\Result\Tests\Entity
 * @group   users
 */
class UserTest extends TestCase
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->user = new User();
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor()
    {
        self::assertEquals(0,$this->user->getId());
        self::assertEmpty($this->user->getUsername());
        self::assertEmpty($this->user->getPassword());
        self::assertEmpty($this->user->getToken());
        self::assertEmpty($this->user->getLastLogin());
        self::assertEmpty($this->user->getEmail());
        self::assertFalse(false,$this->user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId()
    {
        static::assertEmpty($this->user->getId());
        $id = random_int(0,1000);
        $this->user->setId($id);
        static ::assertEquals($id, $this->user->getId());
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername()
    {
       static::assertEmpty($this->user->getUsername());
       $username = 'User'.random_int(0,1000);
       $this->user->setUsername($username);
       static ::assertEquals($username, $this->user->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail()
    {
        static::assertEmpty($this->user->getEmail());
        $email = 'pauloaiza@hotmail.es';
        $this->user->setEmail($email);
        static ::assertEquals($email, $this->user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setLastLogin()
     * @covers \MiW\Results\Entity\User::getLastLogin()
     */
    public function testGetSetLastLogin()
    {
        static::assertEmpty($this->user->getLastLogin());
        //$email = 'pauloaiza@hotmail.es';
        date_format($user->getLastLogin(), 'g:ia \o\n l jS F Y')
      //  $this->user->setLastLogin(new \DateTime());
        static ::assertEquals(new \DateTime(), $this->user->getLastLogin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled()
    {
        self::markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::setToken()
     * @covers \MiW\Results\Entity\User::getToken()
     */
    public function testGetSetToken()
    {
        static::assertEmpty($this->user->getToken());
        $token = 'ABC'.random_int(0,1000);
        $this->user->setToken($token);
        static ::assertEquals($token, $this->user->getToken());
    }

    /**
     * @covers \MiW\Results\Entity\User::getPassword()
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testGetSetPassword()
    {
        static::assertEmpty($this->user->getPassword());
        $password = random_int(0,1000);
        $this->user->setPassword($password);
        static ::assertEquals($password, $this->user->getPassword());
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString()
    {
        self::markTestIncomplete(
            'This test has not been implemented yet.'
        );
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize()
    {
        $user = new User();
        $user->setUsername('Roberth');
        $user->setEmail('pauloaiza@hotmail.es');
        $user->setEnabled('true');
        $valores=array(
            'id'            => $this->user->getId(),
            'username'      => $user->getUsername(),
            'email'         => $user->getEmail(),
            'enabled'       => $user->isEnabled(),
            'password'      => $this->user->getPassword(),
            'lastLogin'     => $this->user->getUsername(),
            'token'         =>$this->user->getToken()
        );
        self::assertEquals($valores,$user->jsonSerialize());
    }
}
