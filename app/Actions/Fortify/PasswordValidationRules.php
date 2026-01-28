<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password as RulesPassword;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    protected function passwordRules(): array
    {
        return ['required', 'string', 'confirmed', RulesPassword::defaults()];
    }
}
