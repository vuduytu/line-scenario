<?php

namespace Cnc\LineScenario\Repositories\Scenario;

use Cnc\LineScenario\Models\Scenario;
use Cnc\LineScenario\Repositories\_Abstract\BaseRepository;
use Cnc\LineScenario\Repositories\Scenario\IScenarioRepo;

class ScenarioRepo extends BaseRepository implements IScenarioRepo
{
    protected $model;

    public function model()
    {
        return Scenario::class;
    }

    public function getSelect()
    {
        return $this->select('id', 'name')->orderBy('name', 'asc')->get();
    }
}
