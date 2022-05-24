<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Categoria;

class CategoriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Categoria::insert(
            [
                [ 'catNombre'=>'Smartphone' ],
                [ 'catNombre'=>'Cámaras mirroless' ],
                [ 'catNombre'=>'Lentes' ],
                [ 'catNombre'=>'Parlantes bluetooth' ],
                [ 'catNombre'=>'Smart TV' ],
                [ 'catNombre'=>'Consolas' ],
                [ 'catNombre'=>'Tablets' ]
            ]
        );


    }
}
