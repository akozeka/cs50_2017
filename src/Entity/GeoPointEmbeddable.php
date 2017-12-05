<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Embeddable
 */
class GeoPointEmbeddable implements GeoPointInterface, \JsonSerializable
{
    /**
     * @ORM\Column(type="geo_point", nullable=true)
     *
     * @Assert\GreaterThanOrEqual(value="-90")
     * @Assert\LessThanOrEqual(value="90")
     */
    private $latitude;

    /**
     * @ORM\Column(type="geo_point", nullable=true)
     *
     * @Assert\GreaterThanOrEqual(value="-180")
     * @Assert\LessThanOrEqual(value="180")
     */
    private $longitude;

    public function jsonSerialize()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }

    public function getLatitude(): ?float
    {
        return $this->latitude;
    }

    public function setLatitude(?float $latitude)
    {
        $this->latitude = $latitude;
    }

    public function getLongitude(): ?float
    {
        return $this->longitude;
    }

    public function setLongitude(?float $longitude)
    {
        $this->longitude = $longitude;
    }
}
