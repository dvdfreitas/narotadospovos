<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait GeneratesAccessCode
{
    /**
     * O "boot" do trait é chamado automaticamente pelo Laravel.
     * Isto engancha-se no evento 'creating' do modelo.
     */
    protected static function bootGeneratesAccessCode(): void
{
    static::creating(function ($model) {
        if (! empty($model->access_code)) {
            return;
        }

        do {
            $code = Str::upper(Str::random(12));
        } while (static::where('access_code', $code)->exists());

        $model->access_code = $code;
    });
}

}