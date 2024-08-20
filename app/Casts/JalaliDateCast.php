<?php

namespace App\Casts;

use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

class JalaliDateCast implements CastsAttributes
{
    /**
     * Cast the given value to Jalali date when retrieving from the database.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return string|null
     */
    public function get($model, string $key, $value, array $attributes): ?string
    {
        return $value ? Jalalian::fromCarbon(Carbon::createFromFormat('Y-m-d', $value))->format('Y/m/d') : null;
    }

    /**
     * Prepare the given value for storage in the database as a Gregorian date.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $key
     * @param mixed $value
     * @param array $attributes
     * @return \Carbon\Carbon|null
     */
    public function set($model, string $key, $value, array $attributes): ?\Carbon\Carbon
    {
        return $value ? Jalalian::fromFormat('Y/m/d', $value)->toCarbon() : null;
    }
}
