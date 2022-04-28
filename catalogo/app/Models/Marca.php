<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;

    public $timestamps = false; //le digo que no tiene timestamps
    protected $primaryKey = 'idMarca'; // le digo que la clave primaria es la nombrada
}
