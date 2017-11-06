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

    /**
     * @var GeoPointEmbeddable
     *
     * @ORM\Embedded(class="AppBundle\Entity\GeoPointEmbeddable", columnPrefix=false)
     */
    private $coordinates;

    public function getPostAddress(): PostAddressEmbeddable
    {
        return $this->postAddress;
    }

    public function getCoordinates(): GeoPointEmbeddable
    {
        return $this->coordinates;
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

    public function getLatitude(): ?float
    {
        return $this->coordinates->getLatitude();
    }

    public function getLongitude(): ?float
    {
        return $this->coordinates->getLongitude();
    }
}
