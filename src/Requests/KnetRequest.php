<?php

namespace Mostafax\Knet\Requests;

use Illuminate\Foundation\Http\FormRequest;

class KnetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'amount'=>['required'],
            'track_id'=>['required','gt:1','integer','unique:payment,track_id'], 
            'udf1'=>['nullable','string'],
            'udf2'=>['nullable','string'],
            'udf3'=>['nullable','string'],
            'udf4'=>['nullable','string'],
            'udf5'=>['nullable','string'],
            'order_id'=> ['nullable','integer|gt:1'], 
        ];
    }
}
