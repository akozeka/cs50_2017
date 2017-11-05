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

    public function __toString()
    {
        return trim($this->getFullName());
    }

    public function getFullName()
    {
        return $this->firstName.' '.$this->lastName;
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }
}
