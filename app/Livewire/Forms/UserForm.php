<?php

namespace App\Livewire\Forms;

use Livewire\Form;

class UserForm extends Form
{
    public $name;
    public $username;
    public $email;
    public $phone_number;
    public $country;
    public $address;

    public function rules()
    {
        // return [
        //     'username' => [
        //         'required',
        //         Rule::unique('users')->ignore($this->username),
        //     ],
        //     'name' => ['required', 'string', 'max:100'],
        //     'email' => ['required', 'min:8'],
        //     'phone_number' =>  ['nullable', 'max:100'],
        // ];
    }
}
