<?php

namespace Cnc\LineScenario\Repositories\ScenarioMessage;

use Cnc\LineScenario\Models\ScenarioMessageModel;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;

class ScenarioMessageRepo extends BaseRepository implements IScenarioMessageRepo
{
    protected $model;

    public function model()
    {
        return ScenarioMessageModel::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
