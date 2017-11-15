<?php // tests/Entity/ResultTest.php

namespace MiW\Results\Tests\Entity;

use MiW\Results\Entity\Result;
use MiW\Results\Entity\User;

/**
 * Class ResultTest
 *
 * @package MiW\Result\Tests\Entity
 */
class ResultTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var User $user
     */
    protected $user;

    /**
     * @var Result $result
     */
    protected $result;

    protected $resultado;

    const USERNAME = 'uSeR ñ¿?Ñ';
    const POINTS = 2017;
    /**
     * @var \DateTime $_time
     */
    private $_time;


    /**
     * Sets up the fixture.
     * This method is called before a test is executed.
     *
     * @return void
     */
    protected function setUp()
    {
        $this->user = new User();
        $this->user->setUsername(self::USERNAME);
        $this->user->setLastLogin(new \DateTime('now'));
        $this->resultado = random_int(0, 100000);
        $this->_time = new \DateTime('now');
        $this->result = new Result($this->_time, $this->user, $this->resultado);
    }

    /**
     * Implement testConstructor
     *
     * @covers \MiW\Results\Entity\Result::__construct()
     * @covers \MiW\Results\Entity\Result::getId()
     * @covers \MiW\Results\Entity\Result::getResult()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @covers \MiW\Results\Entity\Result::getTime()
     *
     * @return void
     */
    public function testConstructor()
    {
        $time = new \DateTime('now');
        $this->result = new Result($time, $this->user, 0);
        self::assertEquals(0, $this->result->getId());
        self::assertEmpty($this->result->getResult());
        self::assertNotEmpty($this->result->getUsers());
        self::assertEquals($time, $this->result->getTime());
    }

    /**
     * Implement testGet_Id().
     *
     * @covers \MiW\Results\Entity\Result::getId()
     * @return void
     */
    public function testGet_Id()
    {
        static::assertEmpty($this->result->getId());
        $id = random_int(0, 1000);
        $this->result->setId($id);
        static::assertEquals($id, $this->result->getId());
    }

    /**
     * Implement testUsername().
     *
     * @covers \MiW\Results\Entity\Result::setResult
     * @covers \MiW\Results\Entity\Result::getResult
     * @return void
     */
    public function testResult()
    {
        static::assertNotEmpty($this->result->getResult());
        $resultado = random_int(0, 1000);
        $this->result->setResult($resultado);
        static::assertEquals($resultado, $this->result->getResult());
    }

    /**
     * Implement testUser().
     *
     * @covers \MiW\Results\Entity\Result::setUser()
     * @covers \MiW\Results\Entity\Result::getUser()
     * @return void
     */
    public function testUser()
    {
        self::assertNotEmpty($this->result->getUsers());
        $this->result->setUsers($this->user);
        static::assertEquals($this->user, $this->result->getUsers());

    }

    /**
     * Implement testTime().
     *
     * @covers \MiW\Results\Entity\Result::setTime
     * @covers \MiW\Results\Entity\Result::getTime
     * @return void
     */
    public function testTime()
    {
        static::assertNotEmpty($this->result->getTime());
        $fecha = new \DateTime('now');
        $this->result->setTime($fecha);
        static::assertEquals($fecha, $this->result->getTime());
    }

    /**
     * Implement testTo_String().
     *
     * @covers \MiW\Results\Entity\Result::__toString
     * @return void
     */
    public function testTo_String()
    {
        $this->result->setId(random_int(0, 1000));
        $this->result->setResult(random_int(0, 1000));
        $this->result->setTime($this->_time);
        $attributes = get_object_vars($this->result);
        self::assertEmpty($attributes, $this->result->__toString());
    }

    /**
     * Implement testJson_Serialize().
     *
     * @covers \MiW\Results\Entity\Result::jsonSerialize
     * @return void
     */
    public function testJson_Serialize()
    {
        $valores = array([
            'id' => $this->result->getId(),
            'result' => $this->result->getResult(),
            'time' => $this->result->getTime(),
            'users_id' => $this->result->getUsers()]
        );
        self::assertEquals($valores, $this->result->jsonSerialize());
    }
}
