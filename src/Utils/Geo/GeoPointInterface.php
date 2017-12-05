<?php

namespace AppBundle\Utils\Geo;

interface GeoPointInterface
{
    public function getLongitude(): ?float;

    public function getLatitude(): ?float;
}
