<?php

namespace App\Models;

use App\Traits\UniversalFilterTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static filter(FilterRequest $filterRequest) - реализация фильтра
 */

class Worker extends Model
{
    use HasFactory, UniversalFilterTrait;

    protected $fillable = [
        'name',
        'second_name',
        'surname',
        'phone'
    ];

    public function excludedOrderTypes(): BelongsToMany
    {
        return $this->belongsToMany(OrderType::class, 'workers_ex_order_types','worker_id','type_id');
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_worker');
    }
}
