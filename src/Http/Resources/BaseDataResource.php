<?php

namespace Cnc\LineScenario\Http\Resources;

use Cnc\LineScenario\Http\Resources\_Abstract\JsonResourceAbstract;

class BaseDataResource extends JsonResourceAbstract
{
    public function toArray($request)
    {
        $data = parent::toArray($request);
        return $data;
    }
}
