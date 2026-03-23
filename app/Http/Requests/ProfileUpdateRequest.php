<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            User::COL_NAME => ['required', 'string', 'max:255'],
            User::COL_EMAIL => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                function ($attribute, $value, $fail) {
                    $user = User::whereBlind(User::COL_EMAIL, 'email_index', $value)
                        ->where(User::COL_ID, '!=', $this->user()->{User::COL_ID})
                        ->first();

                    if ($user) {
                        $fail(trans('validation.unique', ['attribute' => 'email']));
                    }
                },
            ],
        ];
    }
}
