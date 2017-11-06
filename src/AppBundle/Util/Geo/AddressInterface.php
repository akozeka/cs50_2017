<?php

namespace AppBundle\Util\Geo;

interface AddressInterface
{
    public function getCountry(): string;

    public function getCity(): string;

    public function getAddress(): ?string;

    public function getZipCode(): ?string;
}
