<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;
    protected $fillable = [
        "name",
        'category_photo',
    ];

    //Definimos la relación entre Category y Task
    //Una categoría puede estar en muchos articulos
    //En principio un artículo sólo pertenece a una categoría,
    //así que es una relación de uno a muchos
    //Accediendo a la función tasks, des un objeto de tipo Category,
    //podremos saber todos los artículos que tienen esa categoría.
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
