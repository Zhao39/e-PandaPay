<?php

namespace App\Imports;

use App\Models\User;
use App\Rules\PhoneNumberRule;
use App\Services\Website;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $username = strtolower(preg_replace("/\s+/", '', $row['username']));
        $user = new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'username' => $username,
            'phone_number' => $row['phone_number'],
            'country' => $row['country'],
            'password' => Hash::make($row['password']),
            'email_verified_at' => now(),
            'refferal_link' => Website::url(true) . "/ref/{$username}",
        ]);
        $user->assignRole('User');
        return $user;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'unique:users', 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone_number' => ['required', 'min:8', new PhoneNumberRule()],
            'password' => ['required'],
            'country' => ['required'],
        ];
    }
}
