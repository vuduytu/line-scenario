<?php

namespace Cnc\LineScenario\Models;

use Cnc\LineScenario\Models\_Abstracts\BaseModel;
use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Cnc\LineScenario\Models\_Trait\LogAdminActions;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScenarioZipcodeModel extends BaseModel implements MustLogActions
{
    use SoftDeletes, LogAdminActions;

    public $table = 'scenario_zipcodes';

    public $fillable = ['store_id', 'scenario_id', 'scenario_talk_id', 'zipcodes', 'path'];

    public $casts = [
        'zipcodes' => 'array',
    ];

}
