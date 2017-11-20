<?php

namespace AppBundle\Entity;

use AppBundle\Utils\Geo\AddressInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Embeddable
 */
class PostAddressEmbeddable implements AddressInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, options={"fixed": true})
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $zipCode;

    public function __construct(string $country, string $city, ?string $address, ?string $zipCode)
    {
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->zipCode = $zipCode;
    }

    public static function createFromAddress(AddressInterface $address): self
    {
        return new self(
            $address->getCountry(),
            $address->getCity(),
            $address->getAddress(),
            $address->getZipCode()
        );
    }

    public function equals(AddressInterface $other): bool
    {
        return
            mb_strtolower($this->country) === mb_strtolower($other->getCountry()) &&
            mb_strtolower($this->city) === mb_strtolower($other->getCity()) &&
            mb_strtolower($this->address) === mb_strtolower($other->getAddress()) &&
            mb_strtolower($this->zipCode) === mb_strtolower($other->getZipCode());
    }

    public function getCountry(): string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }
}
