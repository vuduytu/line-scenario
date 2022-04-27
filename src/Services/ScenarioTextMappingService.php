<?php

namespace Cnc\LineScenario\Services;

use Cnc\LineScenario\Repositories\ScenarioTextMapping\IScenarioTextMappingRepo;
use Cnc\LineScenario\Services\_Abstract\BaseService;
use Cnc\LineScenario\Services\_Trait\EntryServiceTrait;

class ScenarioTextMappingService extends BaseService
{
    use EntryServiceTrait {
        updateFromRequest as updateFromRequestTrait;
    }

    protected $mainRepository;

    public function __construct(IScenarioTextMappingRepo $entryRepo)
    {
        $this->mainRepository = $entryRepo;
    }

    public function getByScenarioId($scenario)
    {
        $data = $this->mainRepository->where('scenario_id', $scenario->id)->get();
        if (count($data) == 0) {
            $this->mainRepository->create([
                'scenario_id' => $scenario->id,
                'store_id' => $scenario->store_id,
                'dataId' => 'textMapping',
                'dataType' => 'textMapping',
                'textMapping' => [],
            ]);
        }
        $result = $this->mainRepository->where('scenario_id', $scenario->id)->get();
        return $result;
    }
}
