<?php

namespace App\Services;

use App\Http\Requests\FilterRequest;
use App\Repositories\WorkerRepository;
use Exception;
use Illuminate\Support\Collection;

class WorkerService
{
    /**
     * @var WorkerRepository $repository
     */
    protected WorkerRepository $repository;

    /**
     * Конструктор класса
     *
     * @param WorkerRepository $repository
     * @return void
     */
    public function __construct(WorkerRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Получение коллекции с отфильтрованными работниками
     *
     * @param FilterRequest $filterRequest
     * @return Collection
     * @throws Exception
     */
    public function getAll(FilterRequest $filterRequest): Collection
    {
        $workers = $this->repository->getWorkersByFilter($filterRequest->validated())->get();

        if ($workers === null) {
            throw new Exception("Workers not found");
        }

        return $workers;
    }
}
