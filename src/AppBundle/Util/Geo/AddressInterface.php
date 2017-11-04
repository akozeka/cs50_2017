<?php

namespace AppBundle\Util\Geo;

interface AddressInterface
{
    public function getCountry();

    public function getCity();

    public function getAddress();

    public function getZipCode();
}
