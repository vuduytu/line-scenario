<?php

namespace Cnc\LineScenario\Models;

use Cnc\LineScenario\Models\_Abstracts\BaseModel;
use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Cnc\LineScenario\Models\_Trait\LogAdminActions;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScenarioModel extends BaseModel implements MustLogActions
{
    use SoftDeletes, LogAdminActions;

    public $table = 'scenarios';

    public $fillable = [
        "id",
        "store_id",
        "displayVersionName",
        "languages",
        "type",
        "scenario_setting_id",
        "created_by",
        "updated_by",
        'specialTalks',
        'disable_msg'
    ];

    protected $casts = [
        'specialTalks' => 'array',
    ];
}
