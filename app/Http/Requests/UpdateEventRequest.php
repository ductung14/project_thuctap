<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEventRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'admin';
    }

    public function rules()
    {
        return [
            'title' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'start_at' => 'sometimes|required|date',
            'end_at' => 'sometimes|required|date|after_or_equal:start_at',
            'max_participants' => 'sometimes|required|integer|min:1',
            'category_id' => 'sometimes|required|exists:categories,id',
        ];
    }
}