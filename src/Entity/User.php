<?php

namespace App\Entity;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity @ORM\Table(name="users")
 **/
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="smallint", name="user_id")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=60)
     * @var string
     */
    protected $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Item", mappedBy="user", cascade={"persist", "remove"}, fetch="EXTRA_LAZY")
     * @var Item[]|Collection
     */
    protected $items;

    public function __construct()
    {
        $this->items = new ArrayCollection();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return Item[]|Collection
     */
    public function getItems(): Collection
    {
        return $this->items;
    }

    /**
     * @param string $name
     * @return User
     */
    public function setName(string $name): User
    {
        $this->name = $name;

        return $this;
    }
}
