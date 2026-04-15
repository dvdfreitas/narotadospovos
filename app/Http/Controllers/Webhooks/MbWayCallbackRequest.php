<?php

namespace App\Http\Requests\Payments;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Config;

class MbWayCallbackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * We validate the Anti-Phishing key here to secure the webhook.
     */
    public function authorize(): bool
    {
        $inputKey = $this->query('chave'); // IfthenPay sends params in Query String
        $storedKey = Config::get('services.ifthenpay.mbway.callback_key');

        return $inputKey === $storedKey;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'chave'      => ['required', 'string'],
            'referencia' => ['required', 'string'], // This maps to our Donation 'access_code'
            'id'         => ['required', 'string'], // The IfthenPay Request ID
            'valor'      => ['required', 'numeric'],
            'estado'     => ['required', 'string'], // Expected: 'PAGO', 'RECUSADO', etc.
        ];
    }
}