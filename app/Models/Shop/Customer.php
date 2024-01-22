<?php

namespace App\Models\Shop;

use App\Models\Address;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shop_customers';

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'birthday' => 'date',
    ];

    /**
     * Get the addresses for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphToMany
     */
    public function addresses(): MorphToMany
    {
        return $this->morphToMany(Address::class, 'addressable');
    }

    /**
     * Get the comments for the customer.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Get the payments for the customer through orders.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function payments(): HasManyThrough
    {
        return $this->hasManyThrough(Payment::class, Order::class, 'shop_customer_id');
    }

    /**
     * Soft delete the customer.
     *
     * @return void
     */
    public function deleteCustomer()
    {
        $this->delete();
    }

    /**
     * Restore the soft-deleted customer.
     *
     * @return void
     */
    public function restoreCustomer()
    {
        $this->restore();
    }

    /**
     * Permanently delete the customer.
     *
     * @return void
     */
    public function forceDeleteCustomer()
    {
        $this->forceDelete();
    }
}
