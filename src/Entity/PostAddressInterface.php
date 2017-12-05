<?php

namespace AppBundle\Entity;

interface PostAddressInterface
{
    public function getCountry(): string;

    public function getCity(): string;

    public function getAddress(): ?string;

    public function getZipCode(): ?string;
}
