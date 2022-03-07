<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait MultiTenantModelTrait
{
    public static function bootMultiTenantModelTrait()
    {
        if (!app()->runningInConsole() && auth()->check()) {
            $user = auth()->user();

            // static::creating(function ($model) {

            //     $model->created_by_id = auth()->id();

            // });

            if (!$user->is_admin) {

                //try and make it such that only accountant and executive sees everything and credit committee sees forwaded applicaions only

                static::addGlobalScope('created_by_id', function (Builder $builder) use ($user) {

                    $column = 'created_by_id';

                    if ($user->is_accountant) {

                        $column = 'analyst_id';

                        $field = sprintf('%s.%s', $builder->getQuery()->from, $column);

                        $builder->where($field, auth()->id());

                    } else if ($user->is_creditCommittee) {

                        $column = 'cfo_id';

                        $field = sprintf('%s.%s', $builder->getQuery()->from, $column);

                        $builder->where($field, auth()->id());

                    } else {

                        $field = sprintf('%s.%s', $builder->getQuery()->from, $column);

                        $builder->where($field, auth()->id());

                    }
                    
                    
                });
            }

        }
    }
}
