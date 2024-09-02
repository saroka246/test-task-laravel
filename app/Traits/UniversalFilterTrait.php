<?php

namespace App\Traits;

use App\Http\Filters\Interfaces\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

/**
 * Реализация интерфейса FilterInterface;
 *
 * Этот трейт должен быть подключен к модели, по которой происходит фильтра.
 * У этой модели должна быть персональная реализация фильтра.
 * Реализация фильтра должна лежать в директории App\Http\Filter
 *
 */
trait UniversalFilterTrait {

    /**
     *  Применяет фильтр к модели, используя переданный фильтр.
     *
     *
     * @param Builder $builder - Экземпляр модели, к которой применяется фильтр
     * @param FilterInterface $filter - Фильтр, который будет применен к модели
     * @return void
     */
    public function scopeFilter(Builder $builder, FilterInterface $filter): void
    {
        $filter->apply($builder);
    }
}
