<?php

namespace App\Models;

use App\Models\Transaction;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;
use App\Models\Eye;

/**
 * @method static paginate()
 * @method static findOrFail($id)
 * @method static find($id)
 * @property mixed $name
 * @property mixed $email
 * @property mixed $phone
 * @property mixed $address
 * @property mixed $city
 * @property mixed $state
 * @property mixed $customer_type
 * @property false|mixed|string $birthdate
 * @property mixed $gender
 * @property mixed $status
 */
class Customer extends Model
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
     * Get the transactions for the customer.
     */
    public function transactions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Get the transactions for the customer.
     */
    public function eye(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Eye::class);
    }

}
