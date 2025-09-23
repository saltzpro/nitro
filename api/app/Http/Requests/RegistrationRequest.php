<?php

namespace App\Http\Requests;

use App\Models\Registration;
use Illuminate\Foundation\Http\FormRequest;

class RegistrationRequest extends FormRequest
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
            'category_id' => 'required',
            'first_name' => 'required',
            'middle_name' => 'required',
            'last_name' => 'required',
            'address' => 'required',
            'email' => 'required|email',
            'contact_number' => 'required|min:11|max:13',
            'gender' => 'required',
            'dob' => 'required',
            'emergency_contact_person' => 'required',
            'emergency_relationship' => 'required',
            'emergency_contact_number' => 'required',
            'pickup_notes' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'The event category type is required.',
            'dob' => 'The date of birth field is required.'
        ];
    }
    
}
