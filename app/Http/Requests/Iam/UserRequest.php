<?php

namespace App\Http\Requests\Iam;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                Rule::unique('users')->whereNull('deleted_at')->when($this->isMethod('PUT'), fn ($rule) => $rule->ignore($this->user)),
                Rule::requiredIf(function () {
                    return $this->isMethod('post');
                }),
                'lowercase',
                'email',
            ],
            'password' => [
                Rule::requiredIf(function () {
                    return $this->isMethod('post');
                }),
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
            ],
            'role_id' => [
                'required',
                'integer',
                'numeric',
                Rule::exists('roles', 'id')->whereNull('deleted_at')
            ],
        ];
    }
}
