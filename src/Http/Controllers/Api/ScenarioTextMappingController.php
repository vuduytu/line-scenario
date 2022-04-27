<?php

namespace Cnc\LineScenario\Http\Controllers\Api;

use Carbon\Carbon;
use Cnc\LineScenario\Services\ScenarioService;
use Illuminate\Http\Request;
use Cnc\LineScenario\Http\Requests\API\Admin\ScenarioTextMappingUpdateRequest;
use Cnc\LineScenario\Http\Resources\BaseDataResource;
use Cnc\LineScenario\Http\Resources\ScenarioTalkDataTypeCollection;
use Cnc\LineScenario\Http\Resources\ScenarioTalkDataTypeResource;
use Cnc\LineScenario\Http\Resources\ScenarioTextMappingDataTypeResource;
use Cnc\LineScenario\Http\Resources\ScenarioUserMessageDataTypeResource;
use Cnc\LineScenario\Models\Scenario;
use Cnc\LineScenario\Models\ScenarioMessageModel;
use Cnc\LineScenario\Models\ScenarioModel;
use Cnc\LineScenario\Models\ScenarioSettingModel;
use Cnc\LineScenario\Models\ScenarioTalkModel;
use Cnc\LineScenario\Models\ScenarioTextMappingModel;
use Cnc\LineScenario\Models\ScenarioUserMessageModel;
use Cnc\LineScenario\Services\_Exception\AppServiceException;
use Cnc\LineScenario\Services\ScenarioTextMappingService;
use Cnc\LineScenario\Http\Controllers\Controller;

class ScenarioTextMappingController extends Controller
{
    use BaseEntryDataTrait;
    protected $entryService;
    protected $updateRequestClass;

    public function __construct(ScenarioTextMappingService $entryService)
    {
        $this->entryService = $entryService;
        $this->updateRequestClass = ScenarioTextMappingUpdateRequest::class;
    }

    public function getAllTextMappingByScenarioId($scenario_id)
    {
        $scenario = ScenarioModel::find($scenario_id);
        if (!$scenario) {
            return response()->json([
                'result'=> 'ERROR',
                'error_message' => 'シナリオが見つかりません。',
            ]);
        }
        $data = $this->entryService->getByScenarioId($scenario);
        return [
            'items' =>$data,
            'result'=> 'OK'
        ];
    }

    public function getDataType(Request $request, $id)
    {
        $scenario = ScenarioModel::find($id);
        if (!$scenario) {
            return response()->json([
                'result'=> 'ERROR',
                'error_message' => 'シナリオが見つかりません。',
            ]);
        }
        $scenarioTextMapping = ScenarioTextMappingModel::with('scenario')->where('scenario_id', $id)->first();
        $talks = ScenarioTalkModel::with('scenario')->where('scenario_id', $id)->where('deleted_at', NUll)->get();
        $userMessages = ScenarioUserMessageModel::with('scenario')->where('deleted_at', NUll)->where('scenario_id', $id)->get();

        if (!$scenarioTextMapping) {
            return response()->json([
                'error_msg' => 'scenario not found',
            ], HTTP_VALIDATE_FAIL);
        }

        if (!$talks) {
            return [
                'items' => [],
                'result'=> 'OK'
            ];
        }
        $dataType = $request->get('dataType');
        $scenarioId = $request->get('scenarioId');
        $items = [];
        switch ($dataType) {
            case 'talk':
                $items = ScenarioTalkDataTypeResource::collection($talks);
                break;
            case 'userMessage':
                $items[] = [
                    'params' => $this->transferResponse($userMessages),
                    'dataId' => 'userMessage',
                    'dataType' => 'userMessage',
                    'scenario' => $scenarioId . '#' . $id,
                ];
                break;
            case 'textMapping':
                $items[] = new ScenarioTextMappingDataTypeResource($scenarioTextMapping);
                break;
        }
        return [
            'items' => $items,
            'result'=> 'OK'
        ];
    }
    public function getZipCode(Request $request)
    {
        return [
            'zipcodes' => [],
            'result'=> 'Success'
        ];
    }
    public function transferResponse($userMessages)
    {
        $data = [];
        foreach ($userMessages as $message) {
            $data[$message->id] = $message;
        }
        return $data;
    }

    public function saveTextMapping(Request $request) {
        $putItem = $request->get('putItems');
        $scenarioMessage = [];
        $check = false;
        foreach ($putItem as $value) {
            switch ($value['dataType']) {
                case 'talk':
                    if (in_array($value['dataId'], ScenarioService::TEMPLATE_SCENARIO_TALK_IDS)) {
                        $talk = ScenarioTalkModel::find($value['scenario_talk_id']);
                    } else {
                        $talk = ScenarioTalkModel::where('id', $value['dataId'])->first();
                    }

                    $talk->update(['params' => $value['params'], 'updated_at' => Carbon::now()]);
                    $talk->save();
                    $check = true;
                    break;
                case 'textMapping':
                    $ids = explode('#', $value['scenario']);
                    ScenarioTextMappingModel::where('scenario_id', $ids[1])->update(['textMapping' => $value['textMapping'], 'updated_at' => Carbon::now()]);
                    break;
                case 'userMessage':
                    break;
                default:
                    $scenarioMessage[] = $value;
                    break;
            }
        }

        if ($check) {
            $scenario = ScenarioMessageModel::where('scenario_talk_id', $talk->id)->first();
            if ($scenario) {
                ScenarioMessageModel::where('scenario_talk_id', $talk->id)->delete();
            }
            foreach ($scenarioMessage as $value) {
                $value['scenario_talk_id'] = $talk->id;
                $value['scenario_id'] = $talk->scenario_id;
                ScenarioMessageModel::create($value);
            }
        }
        return [
            'result'=> 'OK'
        ];
    }

    public function update($entryId, Request $request)
    {
        try {
            $id = explode('#', $request->get('scenario'));
            $entry = Scenario::find($id[1]);
            if (!$entry) {
                return response()->json([
                    'result' => 'ERROR',
                    'error_message' => 'シナリオが見つかりません。',
                ]);
            }
            $scenarioTextMapping = ScenarioTextMappingModel::with('scenario')->where('scenario_id', $id[1])->first();

            if (!$scenarioTextMapping) {
                return response()->json([
                    'error_msg' => 'scenario not found',
                ], HTTP_VALIDATE_FAIL);
            }
            if (isset($this->saveRequestClass)) {
                $request = resolve($this->saveRequestClass);
            } else if (isset($this->updateRequestClass)) {
                $request = resolve($this->updateRequestClass);
            }
            if (auth()->check()) {
                $request->merge(['updated_by' => auth()->id()]);
            }
            $this->entryService->updateFromRequest($scenarioTextMapping->id, $request);
            ScenarioTalkModel::where('id', $request->get('talkId'))->update(['startMessage' => $request->get('startMessage')]);
            return response()->json([]);
        } catch (AppServiceException $e)
        {
            return response()->json([
                'result' => 'ERROR',
                'error_message' => $e->getMessage(),
            ]);
        }
    }
}
