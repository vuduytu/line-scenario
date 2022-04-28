<?php

namespace Cnc\LineScenario\Repositories\ScenarioTalk;

use Cnc\LineScenario\Models\ScenarioTalkModel;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;

class ScenarioTalkRepo extends BaseRepository implements IScenarioTalkRepo
{
    protected $model;

    public function model()
    {
        return ScenarioTalkModel::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
