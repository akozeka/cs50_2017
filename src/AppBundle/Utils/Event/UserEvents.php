<?php

namespace AppBundle\Utils\Event;

final class UserEvents
{
    const REGISTRATION_COMPLETED = 'user.registration_completed';
    const PROFILE_UPDATED = 'user.profile_updated';

    private function __construct()
    {
    }
}
