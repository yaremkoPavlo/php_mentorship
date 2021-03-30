<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity @ORM\Table(name="items")
 **/
class Item
{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    protected $task;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $created;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    protected $updated;

    /**
     * @ORM\Column(type="boolean")
     * @var bool
     */
    protected $completed = false;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="items")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="user_id")
     * @var User
     */
    protected $user;

    public function __construct()
    {
        $this->created = new \DateTime('now');
        $this->updated = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getTask(): string
    {
        return $this->task;
    }

    /**
     * @return \DateTime
     */
    public function getCreated(): \DateTime
    {
        return $this->created;
    }

    /**
     * @return \DateTime
     */
    public function getUpdated(): \DateTime
    {
        return $this->updated;
    }

    /**
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->completed;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param string $task
     * @return Item
     */
    public function setTask(string $task): Item
    {
        $this->task = $task;

        return $this;
    }

    /**
     * @param \DateTime $created
     * @return Item
     */
    public function setCreated(\DateTime $created): Item
    {
        $this->created = $created;

        return $this;
    }

    /**
     * @param \DateTime $updated
     * @return Item
     */
    public function setUpdated(\DateTime $updated): Item
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @param bool $completed
     * @return Item
     */
    public function setCompleted(bool $completed): Item
    {
        $this->completed = $completed;

        return $this;
    }

    /**
     * @param User $user
     * @return Item
     */
    public function setUser(User $user): Item
    {
        $this->user = $user;

        return $this;
    }
}
