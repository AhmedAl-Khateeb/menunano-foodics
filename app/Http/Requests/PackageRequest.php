<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PackageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        $features = $this->input('features', []);

        if (is_array($features)) {
            $normalizedFeatures = [];

            foreach ($features as $feature) {
                if (is_array($feature)) {
                    $normalizedFeatures[] = $feature['text'] ?? null;
                } else {
                    $normalizedFeatures[] = $feature;
                }
            }

            $this->merge([
                'features'  => $normalizedFeatures,
                'is_active' => $this->boolean('is_active'),
            ]);
        } else {
            $this->merge([
                'features'  => [],
                'is_active' => $this->boolean('is_active'),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'description'      => 'nullable|string',
            'price'            => 'required|numeric|min:0',
            'duration'         => 'required|integer|min:1',
            'is_active'        => 'nullable|boolean',
            'business_type_id' => 'required|exists:business_types,id',
            'features'         => 'nullable|array',
            'features.*'       => 'nullable|string|max:255',
        ];
    }
}