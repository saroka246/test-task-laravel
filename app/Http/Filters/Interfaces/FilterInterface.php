<?php

namespace App\Http\Filters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    /**
     * Требует реализации apply функции у классов, реализующих данный метод
     */

    public function apply(Builder $builder): void;
}
