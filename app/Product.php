<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $appends = ['_links'];

    protected $fillable = [
        'user_id', 'nome', 'descricao', 'preco', 'vendido', 'slug'
    ];

    // Accessors
    public function getLinksAttribute()
    {
        return [
            'href' => route('products.products.show', ['product' => $this->id]),
            'rel' => 'Produtos'
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos()
    {
        return $this->hasMany(ProductPhoto::class);
    }
}
