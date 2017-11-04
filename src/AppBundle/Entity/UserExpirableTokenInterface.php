<?php

namespace AppBundle\Entity;

interface UserExpirableTokenInterface
{
    public static function generate(User $user, $lifetime = '+1 day');

    public function getValue();

    public function getUserId();

    public function getUsageDate();

    public function consume(User $user);

    public function getType();
}
