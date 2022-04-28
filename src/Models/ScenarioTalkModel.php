<?php

namespace Cnc\LineScenario\Models;

use Cnc\LineScenario\Models\_Abstracts\BaseModel;
use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Cnc\LineScenario\Models\_Trait\LogAdminActions;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScenarioTalkModel extends BaseModel implements MustLogActions
{
    use SoftDeletes, LogAdminActions;

    public $table = 'scenario_talks';

    public $fillable = ['store_id', 'scenario_id', 'params', 'dataId', 'dataType', 'displayName', 'numberOfMessage', 'startMessage', 'updated_at', 'special_talk_msg'];

    public $casts = [
        'params' => 'array',
    ];

    public function messages()
    {
        return $this->hasMany(ScenarioMessageModel::class, 'scenario_talk_id');
    }

    public function scenario()
    {
        return $this->belongsTo(Scenario::class, 'scenario_id');
    }

}
