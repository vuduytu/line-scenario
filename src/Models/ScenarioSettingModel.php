<?php

namespace Cnc\LineScenario\Models;

use Cnc\LineScenario\Models\_Abstracts\BaseModel;
use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Cnc\LineScenario\Models\_Trait\LogAdminActions;
use Illuminate\Database\Eloquent\SoftDeletes;


class ScenarioSettingModel extends BaseModel implements MustLogActions
{
    use SoftDeletes, LogAdminActions;

    public $table = 'scenario_settings';

    public $fillable = [
        "id",
        "store_id",
        "name",
        "richMenu",
        "envMapping",
        "type",
        "created_by",
        "updated_by"
    ];

    public function scenarios()
    {
        return $this->hasMany(Scenario::class, 'scenario_setting_id');
    }
}
