<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

trait EntityPostAddressTrait
{
    /**
     * @var PostAddressEmbeddable
     *
     * @ORM\Embedded(class="AppBundle\Entity\PostAddressEmbeddable", columnPrefix=false)
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
