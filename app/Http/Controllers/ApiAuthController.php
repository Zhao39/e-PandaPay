<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Rules\PhoneNumberRule;
use App\Services\Website;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class ApiAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        Validator::make($request, [
            'name' => ['required', 'string', 'max:100'],
            'username' => ['required', 'unique:users', 'regex:/^\S*$/u'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:users'],
            'phone_number' => ['required', 'min:8', new PhoneNumberRule()],
            'password' => ['required', Password::defaults()],
            'country' => ['required'],
            'refferal' => ['nullable', 'exists:users,username'],
        ])->validate();

        $input = $request->all();

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

        return response()->json([
            'message' => 'Registration is successful.',
            'status_code' => 200, // 200 OK to prevent breaking change
            'data' => $user,
        ]);
    }
}
