<?php // src/Entity/User.php

namespace MiW\Results\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * User
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="token_UNIQUE", columns={"token"})})
 * @ORM\Entity
 */
class User implements \JsonSerializable{

    const __CLASS__= __CLASS__;
    const DATE_FORMAT = 'Y/m/d H:i:s';
    const LAST_LOGIN = 'lastLogin';
    const EMAIL = 'email';
    const ID = 'id';
    const ENABLED = 'enabled';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @SuppressWarnings(PHPMD.ShortVariable)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=40, nullable=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, nullable=true)
     */
    private $email;

    /**
     * @var boolean
     *
     * @ORM\Column(name="enabled", type="boolean", nullable=true)
     */
    private $enabled;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, nullable=true)
     */
    private $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="last_login", type="datetime", nullable=true)
     */
    private $lastLogin;

    /**
     * @var string
     *
     * @ORM\Column(name="token", type="string", length=40, nullable=true)
     */
    private $token;


    /**
     * User constructor.
     */
    public function __construct()
    {
        $this->id ;
        $this->username;
        $this->email ;
        $this->enabled;
        $this->token;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @return \DateTime
     */
    public function getLastLogin()
    {
        return $this->lastLogin;
    }

    /**
     * @param \DateTime $lastLogin
     */
    public function setLastLogin($lastLogin)
    {
        $this->lastLogin = $lastLogin;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken($token)
    {
        $this->token = $token;
    }
    /**
     * @inheritDoc
     */
    function __toString(): string
    {
        $attributes = get_object_vars($this);
        $toString = '[OK]  ' ;
        foreach ($attributes as $attributeName => $attributeValue) {
            if ($attributeName === User::LAST_LOGIN)
                $toString .=  $attributeName . ':' . date_format($attributeValue, User::DATE_FORMAT) .' ';
            else
                $toString .= $attributeName . ':' . $attributeValue.' ';
        }

        return $toString;
    }
    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return [[
            'id' => $this->getId(),
            'username' => utf8_encode($this->getUsername()),
            'email' => utf8_encode($this->getEmail()),
            'enabled' => ($this->isEnabled()) ? 'true' : 'false',
            'password' => $this->getPassword(),
            'lastLogin' => $this->getLastLogin(),
            'token' => $this->getToken()]
        ];

    }

}

