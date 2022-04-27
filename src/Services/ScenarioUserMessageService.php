<?php

namespace Cnc\LineScenario\Services;

use Cnc\LineScenario\Repositories\ScenarioUserMessage\IScenarioUserMessageRepo;

class ScenarioUserMessageService
{
    protected $mainRepository;

    public function __construct(IScenarioUserMessageRepo $entryRepo)
    {
        $this->mainRepository = $entryRepo;
    }
}
