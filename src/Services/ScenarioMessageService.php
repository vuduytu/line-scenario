<?php

namespace Cnc\LineScenario\Services;

use Illuminate\Support\Facades\DB;
use Cnc\LineScenario\Models\ScenarioModel;
use Cnc\LineScenario\Models\ScenarioTalkModel;
use Cnc\LineScenario\Models\ScenarioZipcodeModel;
use Cnc\LineScenario\Http\Requests\_Abstracts\BaseRequest;
use Cnc\LineScenario\Repositories\ScenarioMessage\IScenarioMessageRepo;
use Cnc\LineScenario\Services\_Abstract\BaseService;
use Cnc\LineScenario\Services\_Exception\AppServiceException;
use Cnc\LineScenario\Services\_Trait\EntryServiceTrait;

class ScenarioMessageService extends BaseService
{
    use EntryServiceTrait {
        createFromArray as createFromArrayTrait;
        updateFromRequest as updateFromRequestTrait;
    }

    protected $mainRepository;

    public function __construct(IScenarioMessageRepo $entryRepo)
    {
        $this->mainRepository = $entryRepo;
    }

    public function all()
    {
        return $this->mainRepository->all();
    }

    public function getByStoreId($storeId)
    {
        return $this->mainRepository->findWhere(['store_id' => $storeId]);
    }

    public function getByScenarioId($scenarioId)
    {
        return $this->mainRepository->findWhere(['scenario_id' => $scenarioId]);
    }

    public function updateFromRequest($entryId, BaseRequest $request)
    {
        try {
            return $this->mainRepository->update($request->fillData(), $entryId);
        } catch (\Exception $e)
        {
            \Log::info($e->getMessage());
            throw new AppServiceException(__('messages.unknown_error'), SERVER_ERROR);
        }
    }

    public function importZipcodes($data, $scenarioId, $path)
    {
        if (count($data) == 0) {
            throw new AppServiceException(__('messages.unknown_error'), SERVER_ERROR);
        }
        DB::beginTransaction();
        try {
            $scenario = ScenarioModel::find($scenarioId);
            $postCode = ScenarioZipcodeModel::where('scenario_id', $scenarioId)->first();
            if ($postCode) {
                $postCode->update(['zipcodes' => $data, 'path' => $path]);
            }
            ScenarioZipcodeModel::create([
                'scenario_id' => $scenario->id,
                'store_id' => $scenario->store_id,
                'zipcodes' => $data,
                'path' => $path,
            ]);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            throw new AppServiceException(__('messages.unknown_error'), SERVER_ERROR);
        }
    }

    public function getZipCode($data)
    {
        $postCode = ScenarioZipcodeModel::where('scenario_id', $data['scenario'])->first();
        if ($postCode) {
            return $postCode->zipcodes;
        }
        return [];
    }

    public function deleteZipcodes($data)
    {
        $postCode = ScenarioZipcodeModel::where('scenario_id', $data['scenario'])->first();
        if ($postCode) {
            return $postCode->delete();
        }
        return [];
    }

    public function exportZipcodesCSV($data)
    {
        $postCode = ScenarioZipcodeModel::where('scenario_id', $data['scenario'])->first();
        if ($postCode) {
            return $postCode->path;
        }
        return '';
    }
}
