<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['address'];

    protected $hidden = [
        'rua', 'numero', 'bairro', 'complemento', 'cep', 'cidade', 'estado'
    ];

    protected $fillable = [
        'comprador_id', 'vendedor_id', 'product_id', 'rua', 'numero', 'bairro', 'complemento', 'cep', 'cidade', 'estado'
    ];

    public function getAddressAttribute()
    {
        $address = [
            'rua' => $this->street,
            'numero' => $this->number,
            'bairro' => $this->neighborhood,
            'complemento' => $this->complement,
            'cep' => $this->zip_code,
            'cidade' => $this->city,
            'estado' => $this->state
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