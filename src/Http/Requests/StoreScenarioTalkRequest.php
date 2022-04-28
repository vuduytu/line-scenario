<?php

namespace Cnc\LineScenario\Http\Requests;

use Cnc\LineScenario\Http\Requests\_Abstracts\ApiBaseRequest;

class StoreScenarioTalkRequest extends ApiBaseRequest
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
        return [
            'store_id' => 'required',
            'scenario_id' => 'required',
            'talk' => 'required',
            'start_message' => 'required'
        ];
    }
}
