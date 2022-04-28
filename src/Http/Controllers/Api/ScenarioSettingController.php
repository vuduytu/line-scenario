<?php

namespace Cnc\LineScenario\Http\Controllers\Api;

use Cnc\LineScenario\Http\Requests\API\Admin\ScenarioSettingStoreRequest;
use Cnc\LineScenario\Http\Requests\API\Admin\ScenarioSettingUpdateRequest;
use Illuminate\Http\Request;
use Cnc\LineScenario\Http\Controllers\Controller;
use Cnc\LineScenario\Services\ScenarioSettingService;

class ScenarioSettingController extends Controller
{
    use BaseEntryDataTrait;

    protected $entryService;
    protected $createRequestClass;
    protected $updateRequestClass;

    public function __construct(ScenarioSettingService $entryService)
    {
        $this->entryService = $entryService;
        $this->createRequestClass = ScenarioSettingStoreRequest::class;
        $this->updateRequestClass = ScenarioSettingUpdateRequest::class;
    }

    public function index(Request $request)
    {
        $entries = $this->entryService->search();
        $data = [];
        foreach ($entries as $key => $value) {
            $data[$value->name] = $value;
        }

        return response()->json([
            'result' => 'OK',
            'items' => [
                [
                    "activeScenarioId" => "GovTech-program",
                    "scenarioId"=> "settings",
                    "envMapping"=> [
                        "sandbox"=> "govtech-demo-v2",
                        "production"=> "govtech-demo-v2"
                    ]
                ],
                [
                    "versions" => $data,
                    "scenarioId" => "GovTech-program",
                ]
            ]
        ]);
    }

    public function getItem(Request $request)
    {
        $data = json_decode('{
        "item": {
            "activeScenarioId": "GovTech-program",
            "scenarioId": "settings",
            "envMapping": {
                "sandbox": "govtech-demo-v2",
                "production": "govtech-demo-v2"
            }
        }}');
        return response()->json([
            'result' => 'OK',
            'item' => $data->item
        ]);
    }
}
