<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductPhoto extends Model
{
    protected $appends = ['src'];

    protected $fillable = [
        'titulo', 'foto'
    ];

    //caminho da imagem no front:
    //http://127.0.0.1:8000/storage/images/img.jpg
    public function getSrcAttribute()
    {
        $src = asset('storage/' . $this->foto);

        return $src;
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
