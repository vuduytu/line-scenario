<?php

namespace Cnc\LineScenario\Http\Resources;

use Cnc\LineScenario\Models\ScenarioTalkModel;

class ScenarioMessageResource extends BaseDataResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $data = parent::toArray($request);
        $data['scenario'] = $data['scenario_id'] . '#' . $data['scenario_talk_id'];
        return $data;
    }
}
