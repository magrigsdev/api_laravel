<?php

namespace App\Http\Requests;

use App\Utilities\MyMessage;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class PersonnelsRequest extends FormRequest
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
            //
            'name' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'email' => 'required|string|max:255|unique',
            'telephone' => 'required|string|max:255',
            'sexe' => 'required|string|max:50',
            'addresse' => 'required|text',
            'password' => 'required|text',
            'hiring_date' => 'required|date',
            'role_id' => 'required|string|max:255',
        ];
    }
    public function message()
    {
        return [
            MyMessage::data_incorrect(),
        ];
    }
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => false,
            'error' => $validator->errors(),
            'message' => $this->message()
        ], 404));
    }
}
