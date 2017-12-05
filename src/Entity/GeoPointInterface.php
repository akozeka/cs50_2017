<?php

namespace AppBundle\Entity;

interface GeoPointInterface
{
    public function getLongitude(): ?float;

    public function getLatitude(): ?float;
}
