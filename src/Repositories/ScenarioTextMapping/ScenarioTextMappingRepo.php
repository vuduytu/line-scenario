<?php

namespace Cnc\LineScenario\Repositories\ScenarioTextMapping;

use Cnc\LineScenario\Models\ScenarioTextMappingModel;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;

class ScenarioTextMappingRepo extends BaseRepository implements IScenarioTextMappingRepo
{
    protected $model;

    public function model()
    {
        return ScenarioTextMappingModel::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
