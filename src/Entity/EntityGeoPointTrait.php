<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait EntityGeoPointTrait
{
    /**
     * @var GeoPointEmbeddable
     *
     * @ORM\Embedded(class="AppBundle\Entity\GeoPointEmbeddable", columnPrefix=false)
     *
     * @Assert\Valid()
     */
    private $coordinates;

    public function getCoordinates(): GeoPointEmbeddable
    {
        return $this->coordinates;
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
