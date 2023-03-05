<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Customer;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 * @method static find($id)
 * @property mixed $amount
 * @property mixed $refund
 * @property mixed $balance
 * @property mixed $comment
 * @property mixed $axis
 */
class Transaction extends Model
{
    use Searchable;
    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The model's default values for attributes.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the customer that owns the transaction.
     */
    public function customer(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

}
