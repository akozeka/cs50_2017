<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait EntityPersonNameTrait
{
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    public function __toString(): string
    {
        return $this->getFullName();
    }

    public function getFullName(string $delimiter = ' '): string
    {
        return trim("{$this->firstName}{$delimiter}{$this->lastName}");
    }

    public function getFullNameReversed(string $delimiter = ', '): string
    {
        return trim("{$this->lastName}{$delimiter}{$this->firstName}");
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }
}
