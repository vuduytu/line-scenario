<?php

namespace Cnc\LineScenario\Repositories\ScenarioUserMessage;

use Cnc\LineScenario\Models\ScenarioUserMessageModel;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;

class ScenarioUserMessageRepo extends BaseRepository implements IScenarioUserMessageRepo
{
    protected $model;

    public function model()
    {
        return ScenarioUserMessageModel::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
