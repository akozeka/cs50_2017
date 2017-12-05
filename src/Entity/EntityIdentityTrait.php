<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait EntityIdentityTrait
{
    /**
     * The unique auto incremented primary key.
     *
     * @var int|null
     *
     * @ORM\Id
     * @ORM\Column(type="integer", options={"unsigned": true})
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * Returns the primary key identifier.
     *
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }
}
