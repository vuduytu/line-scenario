<?php

namespace Cnc\LineScenario\Models;

use Cnc\LineScenario\Models\_Abstracts\BaseModel;
use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Cnc\LineScenario\Models\_Trait\LogAdminActions;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScenarioTextMappingModel extends BaseModel implements MustLogActions
{
    use SoftDeletes, LogAdminActions;

    public $table = 'scenario_textmaps';

    public $fillable = ['store_id', 'scenario_id', 'params', 'dataId', 'dataType', 'textMapping'];

    public $casts = [
        'textMapping' => 'array',
    ];

    public function scenario()
    {
        return $this->belongsTo(Scenario::class, 'scenario_id');
    }
}
