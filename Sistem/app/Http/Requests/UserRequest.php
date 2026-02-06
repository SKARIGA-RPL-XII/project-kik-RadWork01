<?php

namespace App\Http\Requests\request;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    public $validator;

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        if ($this->isMethod('post')) {
            return $this->createRules();
        }

        return $this->updateRules();
    }

    private function createRules(): array
    {
        return [
            'name' => 'required|max:100',
            'photo' => 'nullable|file|image',
            'email' => 'required|email|unique:m_user',
            'password' => 'required|min:8',
            'phone_number' => 'numeric',
            // 'm_user_roles_id' => 'required',
        ];
    }

    private function updateRules(): array
    {
        return [
            'name' => 'max:100',
            'photo' => 'nullable|file|image',
            'email' => 'email|unique:m_user,email,' . $this->id,
            'phone_number' => 'numeric',
            // 'm_user_roles_id' => 'required',
        ];
    }


}
