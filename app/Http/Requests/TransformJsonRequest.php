<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class TransformJsonRequest extends FormRequest
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
            'Records' => 'required|array|min:1',
            'Records.*.eventVersion' => 'required|string',
            'Records.*.ses' => 'required|array',
            'Records.*.ses.receipt' => 'required|array',
            'Records.*.ses.receipt.timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
            'Records.*.ses.receipt.processingTimeMillis' => 'required|integer',
            'Records.*.ses.receipt.recipients' => 'required|array|min:1',
            'Records.*.ses.receipt.recipients.*' => 'required|email',
            'Records.*.ses.receipt.spamVerdict.status' => 'required|string|in:PASS,FAIL',
            'Records.*.ses.receipt.virusVerdict.status' => 'required|string|in:PASS,FAIL',
            'Records.*.ses.receipt.spfVerdict.status' => 'required|string|in:PASS,FAIL',
            'Records.*.ses.receipt.dkimVerdict.status' => 'required|string|in:PASS,FAIL',
            'Records.*.ses.receipt.dmarcVerdict.status' => 'required|string|in:PASS,FAIL',
            'Records.*.ses.receipt.dmarcPolicy' => 'required|string|in:reject,quarantine,none',
            'Records.*.ses.mail.timestamp' => 'required|date_format:Y-m-d\TH:i:s.v\Z',
            'Records.*.ses.mail.source' => 'required|email',
            'Records.*.ses.mail.destination' => 'required|array|min:1',
            'Records.*.ses.mail.destination.*' => 'required|email',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success'   => false,
            'message'   => 'Validation errors',
            'data'      => $validator->errors()
        ],400));
    }
}
