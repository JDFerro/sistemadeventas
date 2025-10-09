<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Definir la relación con la categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
