<?php

namespace Cnc\LineScenario\Models\_Trait;

use Cnc\LineScenario\Models\_Contracts\MustLogActions;
use Illuminate\Support\Facades\Auth;

trait LogAdminActions
{
    /**
     * Boot the Model.
     */

    public static function boot()
    {
        parent::boot();
        $logModel = app()->make(config('scenario.log_model'));
        if (config('scenario.loggable', false) && $logModel) {
            $loggedIn = Auth::guard(config('scenario.guard_auth'))->user();
            static::created(function ($model) use ($loggedIn, $logModel) {
                if ($model instanceof MustLogActions && !isset($model->prevent_logging)) {
                    $logModel->create([
                        'user_id' => $loggedIn ? $loggedIn->id : \Str::uuid(),
                        'client_ipaddr' => \Request::ip(),
                        'name' => ACTION_CREATE_NAME,
                        'action' => LOG_ACTION_CREATE,
                        'target_table' => $model->getTable(),
                        'target_record_id' => $model->id,
                        'target_before_data' => null,
                        'target_after_data' => self::getTargetAfterData($model)
                    ]);
                }
            });
            static::updated(function ($model) use ($loggedIn, $logModel) {

                if ($model instanceof MustLogActions && $loggedIn && !isset($model->prevent_logging) && $model->isDirty()) {
                    $originalChanges = [];
                    foreach ($model->getDirty() as $field => $value) {
                        $originalChanges[$field] = $model->original[$field] ?? null;
                    }
                    $logModel->create([
                        'user_id' => $loggedIn ? $loggedIn->id : 1,
                        'client_ipaddr' => \Request::ip(),
                        'name' => ACTION_EDIT_NAME,
                        'action' => LOG_ACTION_UPDATE,
                        'target_table' => $model->getTable(),
                        'target_record_id' => $model->id,
                        'target_before_data' => $originalChanges,
                        'target_after_data' => self::getTargetAfterData($model)
                    ]);
                }
            });
            static::deleted(function ($model) use ($loggedIn, $logModel) {

                if ($model instanceof MustLogActions && $loggedIn && !isset($model->prevent_logging)) {
                    $logModel->create([
                        'user_id' => $loggedIn ? $loggedIn->id : null,
                        'client_ipaddr' => \Request::ip(),
                        'name' => ACTION_DELETE_NAME,
                        'action' => LOG_ACTION_DELETE,
                        'target_table' => $model->getTable(),
                        'target_record_id' => $model->id,
                        'target_before_data' => [],
                        'target_after_data' => [],
                    ]);
                }
            });
        }

    }

    public function creator()
    {
        return $this->belongsTo(config('scenario.user_model'), 'creator_id');
    }

    public function updater()
    {
        return $this->belongsTo(config('scenario.user_model'), 'updater_id');
    }

    public function getLogInfo()
    {
        return null;
    }

    public static function getTargetAfterData($model) {
        $exceptFieldLog = $model->exceptFieldLog ? $model->exceptFieldLog : [];
        $dataAttributes = $model->toArray();
        $dataLog = [];
        foreach ($dataAttributes as $fieldName => $value) {
            if ( !in_array($fieldName, $exceptFieldLog)) {
                $dataLog[$fieldName] = $value;
            }
        }

        return $dataLog;
    }
}
