<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityPostAddressTrait
{
    /**
     * @var PostAddressEmbeddable
     *
     * @ORM\Embedded(class="AppBundle\Entity\PostAddressEmbeddable", columnPrefix=false)
     *
     * @Assert\Valid()
     */
    private $postAddress;

    public function getPostAddress(): PostAddressEmbeddable
    {
        return $this->postAddress;
    }

    public function getCountry(): string
    {
        return $this->postAddress->getCountry();
    }

    public function getCity(): string
    {
        return $this->postAddress->getCity();
    }

    public function getAddress(): ?string
    {
        return $this->postAddress->getAddress();
    }

    public function getZipCode(): ?string
    {
        return $this->postAddress->getZipCode();
    }
}
