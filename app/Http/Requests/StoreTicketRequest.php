<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreTicketRequest extends FormRequest
{
    public function authorize():bool
    {
        // Allow all authenticated users (customize as needed)
        return true;
    }

    public function rules(): array
    {
        \Log::info('🧪 StoreTicketRequest::rules hit');

        return [
            'title'             => ['required', 'string', 'max:255'],
            'description'       => ['required', 'string', 'min:10'],
            'priority_id'       => ['required', 'exists:priorities,id'],
            'status_id'         => ['required', 'exists:statuses,id'],
            'categories'        => ['required', 'array', 'min:1'],
            'categories.*'      => ['integer', 'exists:categories,id'],
            'labels'            => ['required', 'array', 'min:1'],
            'labels.*'          => ['integer', 'exists:labels,id'],
            'assigned_user_id'  => ['nullable', 'integer', 'exists:users,id'],
            'files'             => ['nullable', 'array', 'max:5'],
            'files.*'           => ['file', 'mimes:jpg,jpeg,png,pdf,doc,docx', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'            => 'A ticket title is required.',
            'description.required'      => 'Please provide a description for this ticket.',
            'description.min'           => 'Description must be at least 10 characters.',
            'priority_id.required'      => 'Select a priority for the ticket.',
            'priority_id.exists'        => 'Selected priority is invalid.',
            'status_id.required'        => 'Select a status for the ticket.',
            'status_id.exists'          => 'Selected status is invalid.',
            'categories.*.exists'       => 'One or more selected categories are invalid.',
            'labels.*.exists'           => 'One or more selected labels are invalid.',
            'assigned_user_id.exists'   => 'Assigned user does not exist.',
            'files.array'               => 'Uploaded files must be an array.',
            'files.max'                 => 'You can upload a maximum of 5 files.',
            'files.*.mimes'             => 'Each file must be a JPG, JPEG, PNG, PDF, DOC, or DOCX.',
            'files.*.max'               => 'Each file may not exceed 5MB.',
        ];
    }

    public function withValidator(Validator $validator)
    {
        \Log::info('🧪 withValidator triggered');

        $validator->after(function ($validator) {
            $priorityId = $this->input('priority_id');
            $statusId   = $this->input('status_id');

            if ($priorityId == 3 && empty($this->input('categories'))) {
                $validator->errors()->add('categories', 'High priority tickets must have at least one category assigned.');
            }

            if ($statusId == 3 && !$this->input('assigned_user_id')) {
                $validator->errors()->add('assigned_user_id', 'A ticket cannot be closed without being assigned to a user.');
            }
        });
    }

    // ✅ Optional: Log to confirm Laravel lifecycle
    public function getValidatorInstance()
    {
        \Log::info('🧪 getValidatorInstance triggered');
        return parent::getValidatorInstance();
    }
}
