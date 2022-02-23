<?php

namespace App\Traits;

use App\StatementLog;
use Illuminate\Database\Eloquent\Model;

trait Statementable
{
    public static function bootStatementable()
    {
        static::created(function (Model $model) {
            self::statement('User Created', $model);
        });

        static::updated(function (Model $model) {
            
            if (!app()->runningInConsole()) { //the call made was not from a console but the user
                
                
                if($model->isDirty('repaid_amount')){

                    $changedModels = $model->getChanges();
    
                    //\Log::info(" Db updated User". json_encode($changedModels));
    
                    self::statement('User updated', $changedModels, $model->id);
                }
                

            } else {

                //\Log::info(" Db updated Console");

                $changedModels = $model->getChanges();

                self::statement('Console', $changedModels, $model->id);

            }



            if($model->getOriginal('status_id') == 12){ //gets the last changes of the original status. check if the loan application came from partial rejection or not then update if so

                self::updateStatement($model);

            }


        });

        static::deleted(function (Model $model) {
            self::statement('deleted', $model);
        });
    }

    protected static function statement($description, $model, $id = null)
    {

        StatementLog::create([
            'description'  => $description,
            'subject_id'   => $model->id ?? $id,
            'subject_type' => 'App\LoanApplication',
            'user_id'      => auth()->id() ?? null,
            'properties'   => $model ?? null,
            'host'         => request()->ip() ?? null,
        ]);
    }

    protected static function updateStatement($model)
    {
        StatementLog::where('subject_id', $model->id)
        ->update([
            'properties'   => $model ?? null,
            'host'         => request()->ip() ?? null,
        ]);
    }
}
