<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $appends = ['endereco'];

    protected $hidden = [
        'rua', 'numero', 'bairro', 'complemento', 'cep', 'cidade', 'estado'
    ];

    protected $fillable = [
        'comprador_id', 'vendedor_id', 'product_id', 'rua', 'numero', 'bairro', 'complemento', 'cep', 'cidade', 'estado'
    ];

    public function getEnderecoAttribute()
    {
        $endereco = [
            'rua' => $this->rua,
            'numero' => $this->numero,
            'bairro' => $this->bairro,
            'complemento' => $this->complemento,
            'cep' => $this->cep,
            'cidade' => $this->cidade,
            'estado' => $this->estado
        ];

        return $endereco;
    }

    public function comprador()
    {
        return $this->belongsTo(User::class);
    }

    public function vendedor()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}