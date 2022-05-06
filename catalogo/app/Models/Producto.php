<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

   protected $primaryKey = 'idProducto';

   public $timestamps = false;

///metodo de relacion

public function getMarca()
{

        return $this->belongsTo(Marca::class, 'idMarca', 'idMarca');


}

/**
 * Get the user that owns the Producto
 *
 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
 */
public function getCategoria()
{
    return $this->belongsTo(Categoria::class, 'idCategoria', 'idCategoria');
}

}
