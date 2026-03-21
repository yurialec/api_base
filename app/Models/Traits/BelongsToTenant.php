<?php

namespace App\Models\Traits;

use App\Models\Scopes\TenantScope;
use Illuminate\Support\Facades\App;

trait BelongsToTenant
{
    public static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope());

        static::creating(function ($model) {
            if (App::bound('current_tenant')) {
                $model->tenant_id = app('current_tenant')->id;
            }
        });
    }
}
