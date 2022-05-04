<?php

namespace Cnc\LineScenario\Repositories\ScenarioSetting;

use Cnc\LineScenario\Models\ScenarioSettingModel;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;
use Cnc\LineScenario\Repositories\ScenarioSetting\IScenarioSettingRepo;

class ScenarioSettingRepo extends BaseRepository implements IScenarioSettingRepo
{
    protected $model;

    public function model()
    {
        return ScenarioSettingModel::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
