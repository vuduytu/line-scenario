<?php

namespace Cnc\LineScenario\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ScenarioTalkCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public $collects = 'Cnc\LineScenario\Http\Resources\ScenarioTalkResource';

    public function toArray($request)
    {
        return $this->collection;
    }
}
