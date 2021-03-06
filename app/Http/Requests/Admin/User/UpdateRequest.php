<?php

namespace App\Http\Requests\Admin\User;

use App\Http\Requests\Request as BaseRequest;

class UpdateRequest extends BaseRequest
{
    /**
     * The user validation rules.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'username'   => 'required|min:5',
            'email'      => 'required|min:5|email',
            'activated'  => 'integer|boolean',
        ];
    }

    /**
     * Allows all users to create users.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
