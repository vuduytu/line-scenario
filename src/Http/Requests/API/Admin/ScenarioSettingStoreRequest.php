<?php

namespace Cnc\LineScenario\Http\Requests\API\Admin;

use Cnc\LineScenario\Http\Requests\_Abstracts\ApiBaseRequest;

class ScenarioSettingStoreRequest extends ApiBaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "store_id" => '',
            "name" => 'required',
            "richMenu" => '',
            "envMapping" => ''
        ];
    }
}
