<?php

namespace App\Traits;

use App\Models\Scopes\CompanyScope;

trait BelongsToCompany
{
    protected static function bootBelongsToCompany()
    {
        static::addGlobalScope(
            new CompanyScope
        );

        static::creating(function ($model) {

            if (auth()->check()) {

                $model->company_id =
                    auth()->user()->company_id;

            }

        });
    }
}