<?php // tests/Entity/UserTest.php

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

    private $_time;

    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->user = new User();
        $this->_time = new \DateTime('now');
    }

    /**
     * @covers \MiW\Results\Entity\User::__construct()
     */
    public function testConstructor()
    {
        self::assertEquals(0, $this->user->getId());
        self::assertEmpty($this->user->getUsername());
        self::assertEmpty($this->user->getPassword());
        self::assertEmpty($this->user->getToken());
        self::assertEmpty($this->user->setLastLogin($this->_time));
        self::assertEmpty($this->user->getEmail());
        self::assertFalse(false, $this->user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::getId()
     */
    public function testGetId()
    {
        static::assertEmpty($this->user->getId());
        $id = random_int(0, 1000);
        $this->user->setId($id);
        static::assertEquals($id, $this->user->getId());
    }

    /**
     * @covers \MiW\Results\Entity\User::setUsername()
     * @covers \MiW\Results\Entity\User::getUsername()
     */
    public function testGetSetUsername()
    {
        static::assertEmpty($this->user->getUsername());
        $username = 'User' . random_int(0, 1000);
        $this->user->setUsername($username);
        static::assertEquals($username, $this->user->getUsername());
    }

    /**
     * @covers \MiW\Results\Entity\User::getEmail()
     * @covers \MiW\Results\Entity\User::setEmail()
     */
    public function testGetSetEmail()
    {
        static::assertEmpty($this->user->getEmail());
        $email = random_int(0,1000).'@hotmail.es';
        $this->user->setEmail($email);
        static::assertEquals($email, $this->user->getEmail());
    }

    /**
     * @covers \MiW\Results\Entity\User::setLastLogin()
     * @covers \MiW\Results\Entity\User::getLastLogin()
     */
    public function testGetSetLastLogin()
    {
        static::assertEmpty($this->user->getLastLogin());
        $fecha = new \DateTime('now');
        $this->user->setLastLogin($fecha);
        static::assertEquals($fecha, $this->user->getLastLogin());
    }

    /**
     * @covers \MiW\Results\Entity\User::setEnabled()
     * @covers \MiW\Results\Entity\User::isEnabled()
     */
    public function testIsSetEnabled()
    {
        static::assertEmpty($this->user->isEnabled());
        $estado = '0';
        $this->user->setEnabled($estado);
        static::assertEquals($estado, $this->user->isEnabled());
    }

    /**
     * @covers \MiW\Results\Entity\User::setToken()
     * @covers \MiW\Results\Entity\User::getToken()
     */
    public function testGetSetToken()
    {
        static::assertEmpty($this->user->getToken());
        $token = md5('ABC', 1000);
        $this->user->setToken($token);
        static::assertEquals($token, $this->user->getToken());
    }

    /**
     * @covers \MiW\Results\Entity\User::getPassword()
     * @covers \MiW\Results\Entity\User::setPassword()
     * @covers \MiW\Results\Entity\User::validatePassword()
     */
    public function testGetSetPassword()
    {
        static::assertEmpty($this->user->getPassword());
        $password = md5('MiW').random_int(0, 1000);
        $this->user->setPassword($password);
        static::assertEquals($password, $this->user->getPassword());
    }

    /**
     * @covers \MiW\Results\Entity\User::__toString()
     */
    public function testToString()
    {

        $this->user->setUsername(random_int(0, 10000));
        $this->user->setEmail(random_int(0, 1000) . '@hotmail.com');
        $this->user->setEnabled(true);
        $this->user->setPassword(random_int(0, 10));
        $this->user->setLastLogin($this->_time);
        $this->user->setToken(md5('MiW', 1000));
        $attributes = get_object_vars($this->user);
        self::assertEmpty($attributes, $this->user->__toString());
    }

    /**
     * @covers \MiW\Results\Entity\User::jsonSerialize()
     */
    public function testJsonSerialize()
    {
        self::assertJson(json_encode($this->user->jsonSerialize()));
    }
}
