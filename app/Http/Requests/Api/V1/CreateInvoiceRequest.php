<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreateInvoiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id'       => 'nullable|integer|exists:customers,id',
            'customer'          => 'nullable|array|required_without:customer_id',
            'customer.name'     => 'required_with:customer|string|max:255',
            'customer.company_name' => 'nullable|string|max:255',
            'customer.email'    => 'nullable|email|max:255',
            'customer.phone'    => 'required_with:customer|string|max:50',
            'customer.tax_id'   => 'nullable|string|max:50',
            'customer.address'  => 'nullable|string|max:500',
            'customer.metadata' => 'nullable|array',

            'invoice_number'    => 'nullable|string|max:100|unique:invoices,invoice_number',
            'invoice_date'      => 'nullable|date',
            'due_date'          => 'nullable|date',
            'currency'          => 'nullable|string|max:10',
            'notes'             => 'nullable|string|max:1000',
            'terms'             => 'nullable|string|max:2000',
            'metadata'          => 'nullable|array',

            'items'             => 'required|array|min:1',
            'items.*.name'      => 'required|string|max:255',
            'items.*.description' => 'nullable|string|max:500',
            'items.*.qty'       => 'required|numeric|min:0.01',
            'items.*.rate'      => 'required|numeric|min:0',

            'tax_rate'          => 'nullable|numeric|min:0|max:100',
            'tax_percentage'    => 'nullable|numeric|min:0|max:100',
            'discount_amount'   => 'nullable|numeric|min:0',
            'discount_type'     => 'nullable|string|in:fixed,percentage',
            'need_tax'          => 'nullable|boolean',
            'status'            => 'nullable|string|in:draft,pending,paid,unpaid,overdue,canceled',
            'paid_amount'       => 'nullable|numeric|min:0',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'error'   => 'Validation Failed',
            'errors'  => $validator->errors(),
        ], 422));
    }
}
