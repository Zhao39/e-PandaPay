<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\WelcomeMail;
use App\Models\EmailTemplate;
use App\Models\User;
use App\Services\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirect($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function authenticate(Request $request, $social)
    {
        $userSocial = Socialite::driver($social)->user();

        $user = User::where(['email' => $userSocial->getEmail()])->first();

        if ($user) {
            Auth::login($user);
            $user->assignRole('User');
            return to_route('user.dashboard');
        }

        if ($request->session()->has('ref_by')) {
            $ref_by = $request->session()->get('ref_by');
            $referral = User::select('id')->firstWhere('username', $ref_by);
            if (! $referral) {
                $ref_by_id = null;
            } else {
                $ref_by_id = $referral->id;
            }
        } else {
            $ref_by_id = null;
        }

        $password = $this->RandomStringGenerator(8);
        $username = str_replace(' ', '', $userSocial->getName()) . rand(100, 999);

        $user = User::create([
            'name' => $userSocial->getName(),
            'email' => $userSocial->getEmail(),
            'email_verified_at' => now(),
            'status' => 'active',
            'reffered_by' => $ref_by_id,
            'refferal_link' => Website::url(true) . "/ref/{$username}",
            'username' => $username,
            'password' => Hash::make($password),
        ]);

        Auth::login($user);

        $user->assignRole('User');

        $request->session()->forget('ref_by');

        try {
            $template = EmailTemplate::firstWhere('name', 'welcome_email');
            Mail::to($user->email)->send(new WelcomeMail($user, $template));
            return redirect()->route('user.dashboard');
        } catch (\Throwable) {
            return redirect()->route('user.dashboard');
        }
    }

    private function RandomStringGenerator($n)
    {
        $generated_string = '';
        $domain = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $len = strlen($domain);
        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, $len - 1);
            $generated_string .= $domain[$index];
        }
        // Return the random generated string
        return $generated_string;
    }
}
