<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * Constraint for the Unique Registration validator.
 *
 * @Annotation
 * @Target({"CLASS", "ANNOTATION"})
 */
class UniqueRegistration extends Constraint
{
    public $message = 'User with specified e-mail address already registered!';
    public $service = 'app.validator.unique_registration';

    public function validatedBy()
    {
        return $this->service;
    }

    public function getTargets()
    {
        return self::CLASS_CONSTRAINT;
    }
}
