<?php

namespace Cnc\LineScenario\Services;

use Cnc\LineScenario\Http\Requests\API\Admin\ScenarioSettingStoreRequest;
use Cnc\LineScenario\Repositories\ScenarioSetting\IScenarioSettingRepo;
use Cnc\LineScenario\Services\_Abstract\BaseService;
use Cnc\LineScenario\Services\_Exception\AppServiceException;
use Cnc\LineScenario\Services\_Trait\EntryServiceTrait;

class ScenarioSettingService extends BaseService
{
    use EntryServiceTrait {
        createFromArray as createFromArrayTrait;
        updateFromRequest as updateFromRequestTrait;
    }

    protected $mainRepository;

    public function __construct(IScenarioSettingRepo $entryRepo)
    {
        $this->mainRepository = $entryRepo;
    }


    public function createFromRequest(ScenarioSettingStoreRequest $request)
    {
        $request->merge(['store_id' => auth()->user()->store_id]);

        try {
            return $this->mainRepository->create($request->fillData());
        } catch (\Exception $e)
        {
            \Log::info($e->getMessage());
            throw new AppServiceException(__('messages.unknown_error'), SERVER_ERROR);
        }
    }

}
