<?php

namespace Stevebauman\Maintenance\Validators\Login;

use Stevebauman\Maintenance\Validators\BaseValidator;

/**
 * Class AuthLoginValidator.
 */
class LoginValidator extends BaseValidator
{
    /**
     * The login validation rules.
     *
     * @var array
     */
    protected $rules = [
        'email' => 'required',
        'password' => 'required',
    ];
}
