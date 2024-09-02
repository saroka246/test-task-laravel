<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
      'type_id',
      'partnership_id',
      'user_id',
      'description',
      'date',
      'address',
      'amount',
      'status'
    ];

    public function orderType(): BelongsTo
    {
        return $this->belongsTo(OrderType::class, 'type_id');
    }

    public function partnership(): BelongsTo
    {
        return $this->belongsTo(Partnership::class, 'partnership_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function workers(): BelongsToMany
    {
        return $this->belongsToMany(Worker::class, 'order_worker');
    }
}
