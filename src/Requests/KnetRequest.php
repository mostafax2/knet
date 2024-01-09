<?php

namespace Mostafax\Knet\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Contracts\Validation\Validator; 
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;

class KnetRequest extends FormRequest
{



    protected function failedValidation(Validator $validator)
    {
        $response = new JsonResponse([
            'status' => 'error',
            'message' => 'Validation failed',
            'errors' => $validator->errors(),
        ], 422);

        throw new HttpResponseException($response);
    }

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
            'amount'=>['required'],
            'track_id'=>['required','gt:1','integer','unique:payments,track_id'], 
            'udf1'=>['required','nullable','string'],
            'udf2'=>['required','nullable','string'],
            'udf3'=>['required','nullable','string'],
            'udf4'=>['required','nullable','string'],
            'udf5'=>['required','nullable','string'],
            'order_id'=> ['nullable','integer','gt:1'], 
        ];
    }
}
