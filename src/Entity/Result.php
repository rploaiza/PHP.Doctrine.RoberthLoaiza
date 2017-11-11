<?php // src/Entity/Result.php
namespace MiW\Results\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Result
 * @ORM\Entity
 * @ORM\Table(name="results", indexes={@ORM\Index(name="fk_results_users_idx", columns={"users_id"})})
 *
 */
class Result implements \JsonSerializable
{
    const __CLASS__ = __CLASS__;
    const DATE_FORMAT = 'Y/m/d H:i:s';
    const TIME_ATTRIBUTE = 'time';
    const ID = 'id';
    const USER = 'users';

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="result", type="integer", nullable=true)
     */
    private $result;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime", nullable=true)
     */
    private $time;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User", fetch="EAGER")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="users_id", referencedColumnName="id")
     * })
     */
    private $users;

    /**
     * Result constructor.
     * @param int $result
     * @param \DateTime $time
     * @param User $users
     */
    public function __construct(\DateTime $time, User $users, $result)
    {
        $this->id = 0;
        $this->result = $result;
        $this->time = $time;
        $this->users = $users;
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
     * @return int
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param int $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

    /**
     * @return \DateTime
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * @param \DateTime $time
     */
    public function setTime(\DateTime $time)
    {
        $this->time = $time;
    }

    /**
     * @return User
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param User $users
     */
    public function setUsers($users)
    {
        $this->users = $users;
    }

    public function __toString(): string
    {
        $attributes = get_object_vars($this);
        $toString = '[OK]  ';
        foreach ($attributes as $attributeName => $attributeValue) {
            if ($attributeName === Result::TIME_ATTRIBUTE)
                $toString .= ' ' . $attributeName . ':' . date_format($attributeValue, Result::DATE_FORMAT) . ' ';
            else
                $toString .= ' ' . $attributeName . ':' . $attributeValue . ' ';
        }
        return $toString;
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize(): array
    {
        return array(
            'id' => $this->id,
            'users_id' => $this->users,
            'result' => $this->result,
            'time' => $this->time
        );
    }
}