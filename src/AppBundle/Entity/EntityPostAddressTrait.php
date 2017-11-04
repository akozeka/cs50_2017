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
    protected $postAddress;

    /**
     * @var GeoPointEmbeddable
     *
     * @ORM\Embedded(class="AppBundle\Entity\GeoPointEmbeddable", columnPrefix=false)
     */
    protected $coordinates;

    /**
     * @return PostAddressEmbeddable
     */
    public function getPostAddress()
    {
        return $this->postAddress;
    }

    /**
     * @return GeoPointEmbeddable
     */
    public function getCoordinates()
    {
        return $this->coordinates;
    }

    public function getCountry()
    {
        return $this->postAddress->getCountry();
    }

    public function getCity()
    {
        return $this->postAddress->getCity();
    }

    public function getAddress()
    {
        return $this->postAddress->getAddress();
    }

    public function getZipCode()
    {
        return $this->postAddress->getZipCode();
    }

    public function getLatitude()
    {
        return $this->coordinates->getLatitude();
    }

    public function getLongitude()
    {
        return $this->coordinates->getLongitude();
    }
}