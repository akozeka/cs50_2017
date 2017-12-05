<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Embeddable
 */
class PostAddressEmbeddable implements PostAddressInterface
{
    /**
     * @var string
     *
     * @ORM\Column(type="string", length=2, options={"fixed": true})
     *
     * @Assert\NotBlank
     * @Assert\Length(max=2)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank
     * @Assert\Length(max=255)
     */
    private $city;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     *
     * @Assert\Length(max=255)
     */
    private $address;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", length=5, nullable=true)
     *
     * @Assert\Length(max=5)
     */
    private $zipCode;

    public function __construct(string $country, string $city, ?string $address = null, ?string $zipCode = null)
    {
        $this->country = $country;
        $this->city = $city;
        $this->address = $address;
        $this->zipCode = $zipCode;
    }

    public static function createFromAddress(PostAddressInterface $address): self
    {
        return new self(
            $address->getCountry(),
            $address->getCity(),
            $address->getAddress(),
            $address->getZipCode()
        );
    }

    public function equals(PostAddressInterface $other): bool
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

    public function getFullAddress(): string
    {
        return
            "{$this->country}, {$this->city}" .
            (empty($this->address) ? '' : ", {$this->address}") .
            (empty($this->zipCode) ? '' : ", {$this->zipCode}");
    }
}
