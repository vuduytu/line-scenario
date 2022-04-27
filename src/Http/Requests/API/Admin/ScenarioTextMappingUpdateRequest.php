<?php

namespace Cnc\LineScenario\Http\Requests\API\Admin;

use Cnc\LineScenario\Http\Requests\_Abstracts\ApiBaseRequest;
use Illuminate\Validation\Rule;

class ScenarioTextMappingUpdateRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'textMapping' => '',
            'dataId' => '',
            'dataType' => '',
        ];
    }
}
