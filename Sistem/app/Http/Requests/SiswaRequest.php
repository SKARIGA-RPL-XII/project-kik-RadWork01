<?php

namespace App\Http\Requests;

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
                'errors'  => $validator->errors(),
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
        return [
            'nis' => [
            'required',
            Rule::unique('m_siswa', 'nis')
                ->ignore($this->route('id'))
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
