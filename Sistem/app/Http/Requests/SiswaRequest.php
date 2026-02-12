<?php

namespace App\Http\Requests;

use App\Models\SiswaModel;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class SiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'message' => 'Validation error',
                'errors' => $validator->errors(),
            ], 422)
        );
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
            'email' => 'required|email|unique:m_user,email',
            'password' => 'required|string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'm_role_id' => 'required|exists:m_role,id',
            'status' => 'required|boolean',
            'nis' => 'required|unique:m_siswa,nis',
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:m,f',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'photo_url' => 'nullable|file|image',
        ];
    }

    private function updateRules(): array
    {
        $siswa = SiswaModel::findOrFail($this->route('id'));

        return [
            'email' => [
                'required',
                'email',
                Rule::unique('m_user', 'email')
                    ->ignore($siswa->m_user_id)
            ],
            'password' => 'string|min:8|regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/',
            'm_role_id' => 'required|exists:m_role,id',
            'm_user_id' => 'required|exists:m_user,id',
            'status' => 'required|boolean',
            'nis' => [
                'required',
                Rule::unique('m_siswa', 'nis')
                    ->ignore(id: $siswa->id)
            ],
            'nama' => 'required',
            'jenis_kelamin' => 'required|in:m,f',
            'tanggal_lahir' => 'required',
            'alamat' => 'required',
            'telepon' => 'required',
            'photo_url' => 'nullable|file|image',
        ];
    }
}
