<?php

namespace App\Http\Filters;

use App\Http\Filters\Interfaces\AbstractFilter;
use App\Models\Worker;
use Illuminate\Database\Eloquent\Builder;

class WorkerFilter extends AbstractFilter
{

    /**
     * Реализация метода getCallbacks
     *
     * @return array[]
     */
    protected function getCallbacks(): array
    {
        return [
            self::EXCLUDE=> [$this, 'filterExclude'],
        ];
    }

    /**
     * Реализация метода filterExclude, возвращает работников, которые работают с данными типами заказов
     *
     * @param Builder $builder
     * @param array $values
     * @return Builder
     */
    protected function filterExclude(Builder $builder, array $values): Builder
    {
        $result = '';

        switch (gettype($values)) {
            case 'array':
                $tmp = Worker::whereHas('excludedOrderTypes', function (Builder $builder) use ($values){
                    $builder->distinct()->whereIn('id', $values);
                }, '=', count($values))->pluck('id')->toArray();

                $result = $builder->whereNotIn('id',$tmp);
                break;
        };

        return $result;
    }
}
