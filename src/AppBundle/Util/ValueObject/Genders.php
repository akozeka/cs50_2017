<?php

namespace AppBundle\Util\ValueObject;

final class Genders
{
    const MALE = 'male';
    const FEMALE = 'female';

    const ALL = [
        self::MALE,
        self::FEMALE,
    ];

//    const CHOICES = [
//        'common.gender.mister' => self::MALE,
//        'common.gender.miss' => self::FEMALE,
//    ];

    public static function all()
    {
        return self::ALL;
    }
}