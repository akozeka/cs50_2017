<?php

namespace AppBundle\Util\Geo;

interface GeoPointInterface
{
    public function getLongitude(): ?float;

    public function getLatitude(): ?float;
}
