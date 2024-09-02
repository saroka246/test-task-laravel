<?php

namespace App\Http\Filters\Interfaces;

use Illuminate\Database\Eloquent\Builder;

/**
 * Реализация FilterInterface.
 *
 * Для корректной работы фильтра, для каждой модели использующей фильтр
 * должна быть реализация метода getCallbacks()
 *
 * Каждый параметр метода getCallbacks должен иметь реализацию в фильтре, наследующем
 * этот абстрактный класс
 *
 * Примеры реализации фильтра можно найти в App\Http\Filters;
 */
abstract class AbstractFilter implements FilterInterface
{
    const EXCLUDE = "exclude";
    /**
     * Ассоциативный массив параметров фильтра
     * @var array
     */
    private array $queryParams = [];


    /**
     * Конструктор класса
     *
     * @param array $queryParams
     * @return void
     */
    public function __construct(array $queryParams)
    {
        $this->queryParams = $queryParams;
    }


    /**
     * Реализация метода интерфейса
     *
     * @param Builder $builder
     * @return void
     */
    public function apply(Builder $builder): void
    {
        foreach ($this->getCallbacks() as $name => $callback) {
            if (isset($this->queryParams[$name])) {
                call_user_func($callback, $builder, $this->queryParams[$name]);
            }
        }
    }

    /**
     * Требует реализации getCallback функции у классов, реализующих метод фильтра
     * @return array
     */
    abstract protected function getCallbacks(): array;

    /**
     * Требует реализации filterExclude функции у классов, реализующих метод фильтра
     * @param Builder $builder
     * @param array $values
     * @return Builder
     */
    abstract protected function filterExclude(Builder $builder, array $values): Builder;

}
