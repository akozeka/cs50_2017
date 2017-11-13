<?php

namespace AppBundle\Utils\Geo;

use Symfony\Component\Validator\Constraints as Assert;

class Address implements AddressInterface
{
    /**
     * @Assert\NotBlank
     * @Assert\Length(max=2)
     */
    public $country = '';

    /**
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    public $city = '';

    /**
     * @Assert\Length(max=150)
     */
    public $address = '';

    /**
     * @Assert\Length(max=15)
     */
    public $zipCode = '';

    public function getCountry(): string
    {
        return $this->country;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public static function createFromAddress(AddressInterface $other): self
    {
        $address = new self();
        $address->country = $other->getCountry();
        $address->city = $other->getCity();
        $address->address = $other->getAddress();
        $address->zipCode = $other->getZipCode();

        return $address;
    }
}
