<?php

namespace Locastic\Component\ZxcvbnPasswordValidator\Validator\Constraints;

use Symfony\Component\Validator\Constraint;


class ZxcvbnPassword extends Constraint
{
    public $message = 'password_too_weak';
    public $minScore;

    public function getRequiredOptions()
    {
        return ['minScore'];
    }
}