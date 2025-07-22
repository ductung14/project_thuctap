<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEventRequest extends FormRequest
{
    public function authorize()
    {
        return $this->user()->role === 'organizer';
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|max:2048',
            'start_at' => 'required|date',
            'end_at' => 'required|date|after_or_equal:start_at',
            'max_participants' => 'required|integer|min:1',
            'category_id' => 'required|exists:categories,id',
        ];
    }
}