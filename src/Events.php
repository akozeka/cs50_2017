<?php

namespace AppBundle;

final class Events
{
    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const USER_REGISTRATION_COMPLETED = 'user.registration_completed';

    /**
     * @Event("Symfony\Component\EventDispatcher\GenericEvent")
     *
     * @var string
     */
    const USER_PROFILE_UPDATED = 'user.profile_updated';
}
