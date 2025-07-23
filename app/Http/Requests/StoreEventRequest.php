<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'capacity' => 'required|integer|min:1',
            'status' => 'nullable|in:upcoming,ongoing,completed',
        ];
    }
}