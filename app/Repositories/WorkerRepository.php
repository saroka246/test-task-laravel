<?php

namespace App\Repositories;

use App\Http\Filters\WorkerFilter;
use App\Models\Worker;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;

class WorkerRepository
{
    /**
     * Реализация фильтра
     *
     * @param array $filter_valid_request
     * @return mixed
     * @throws BindingResolutionException
     */
    private function filterMake(array $filter_valid_request) {
        return app()->make(WorkerFilter::class, ['queryParams' => array_filter($filter_valid_request)]);
    }

    /**
     * Метод для получения работников по фильтру
     *
     * @param array $filter_valid_request
     * @return Builder
     * @throws \Exception
     */
    public function getWorkersByFilter(array $filter_valid_request): Builder
    {
        try {
            return Worker::filter($this->filterMake($filter_valid_request));
        } catch (BindingResolutionException $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
