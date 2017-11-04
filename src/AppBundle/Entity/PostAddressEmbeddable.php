<?php

namespace AppBundle\Entity;

use AppBundle\Util\Geo\AddressInterface;
use AppBundle\Util\Geo\GeoCoordinates;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class PostAddressEmbeddable implements AddressInterface
{
    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=2, options={"fixed": true})
     */
    private $country;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $zipCode;

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param null|string $country
     * @return PostAddressEmbeddable
     */
    public function setCountry($country)
    {
        $this->country = $country;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param null|string $city
     * @return PostAddressEmbeddable
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param null|string $address
     * @return PostAddressEmbeddable
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }

    /**
     * @param null|string $zipCode
     * @return PostAddressEmbeddable
     */
    public function setZipCode($zipCode)
    {
        $this->zipCode = $zipCode;
        return $this;
    }
}
