<?php

namespace AppBundle\Utils\ValueObject;

final class Genders
{
    const MALE = 'male';
    const FEMALE = 'female';

    const ALL = [
        self::MALE,
        self::FEMALE,
    ];

    const CHOICES = [
        'male' => self::MALE,
        'female' => self::FEMALE,
    ];

    public static function all()
    {
        return self::ALL;
    }
}
