<?php

namespace App\Models\Concerns;

use App\Models\Store;

trait BelongsToStore
{
    public static function bootBelongsToStore()
    {
        static::addGlobalScope('tenant', function ($builder) {
            if (app()->bound('tenant')) {
                $builder->where($builder->getModel()->getTable() . '.store_id', app('tenant')->id);
            }
        });

        static::creating(function ($model) {
            if (empty($model->store_id) && app()->bound('tenant')) {
                $model->store_id = app('tenant')->id;
            }
        });
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }
}
