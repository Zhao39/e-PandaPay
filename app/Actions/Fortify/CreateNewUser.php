<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\PhoneNumberRule;
use App\Services\Website;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'unique:users', 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone_number' => ['required', 'min:8', new PhoneNumberRule()],
            'password' => ['required', Password::defaults()],
            'country' => ['required'],
            'refferal' => ['nullable', 'exists:users,username'],
        ])->validate();

        if ($input['refferal']) {
            $refferal = User::query()->select('id')->firstWhere('username', $input['refferal']);
            $id = $refferal->id;
        } else {
            $id = null;
        }

        $username = strtolower($input['username']);

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'phone_number' => $input['phone_number'],
            'username' => $username,
            'country' => $input['country'],
            'reffered_by' => $id,
            'password' => Hash::make($input['password']),
            'refferal_link' => Website::url(includeConnection: true) . "/ref/{$username}",
        ]);

        $user->assignRole('User');

        return $user;
    }
}
