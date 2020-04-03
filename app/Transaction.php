<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['address'];

    protected $hidden = [
        'street', 'number', 'neighborhood', 'complement', 'zip_code', 'city', 'state'
    ];

    protected $fillable = [
        'purchaser_id', 'vendor_id', 'product_id', 'street', 'number', 'neighborhood', 'complement', 'zip_code', 'city', 'state'
    ];

    public function getAddressAttribute()
    {
        $address = [
            'street' => $this->street,
            'number' => $this->number,
            'neighborhood' => $this->neighborhood,
            'complement' => $this->complement,
            'zip_code' => $this->zip_code,
            'city' => $this->city,
            'state' => $this->state
        ];

        return $address;
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class);
    }

    public function vendor()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}