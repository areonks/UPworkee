<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GetJobVacanciesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $fieldList = [
            'id',
            'liked_users_count',
            'vacancy_responses_count',
            'created_at',

        ];

        return [
            'tag_name' => 'string|max:30',
            'sort_field' =>[Rule::in($fieldList), 'nullable'],
            'sort_order' => "in:desc,asc",
            'start_date'=>'string|max:30',
            'end_date'=>'string|max:30',
        ];
    }
}
