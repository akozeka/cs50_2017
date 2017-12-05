<?php

namespace AppBundle\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
class Recaptcha extends Constraint
{
    public $message = 'Invalid re-captcha!';
    public $service = 'app.validator.recaptcha';

    public function validatedBy()
    {
        return $this->service;
    }
}
