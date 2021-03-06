<?php

namespace Cnc\LineScenario\Http\Middleware;

use Closure;
use Cnc\LineScenario\Models\ScenarioModel;

class UserStoreHasScenario
{
    public function handle($request, Closure $next)
    {
        $authStoreId = auth()->user()->store_id;
        $scenarioId = $request->route()->parameters()['scenarioId'];
        $scenario = ScenarioModel::find($scenarioId);
        if ($scenario->store_id == $authStoreId) {
            return $next($request);
        }
        return response()->json([
            'message' => 'HTTP_FORBIDDEN'
        ], HTTP_FORBIDDEN_CODE);
    }
}
