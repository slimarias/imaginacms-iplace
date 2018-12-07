<?php

namespace Modules\Iplaces\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class CreatePlaceRequest extends BaseFormRequest
{
    public function rules()
    {
        return [
            'category_id'=>'required',
            'address'=>'required'
        ];
    }

    public function translationRules()
    {
        return [
            'title'=>'required:min2',
            'description'=>'required:min2',

        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [
            'title.required' => trans('iplaces::places.messages.name is required'),
            'title.min2'=>trans('iplaces::places.messages.name is min '),
            'description.required' => trans('iplaces::places.messages.description is required'),
            'description.min2'=>trans('iplaces::places.messages.description is min '),
            'category_id.required'=>trans('iplaces::places.messages.category is required'),
            'address.required' => trans('iplaces::places.messages.address is required'),
        ];
    }
}
