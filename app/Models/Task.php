<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Task extends Model
{
    use HasFactory;

    // Datos que permitimos rellenar
    protected $fillable = [
        'title',
        'user_id',
        'category_id',
        'description',
        'due_date',
        'status',
        'priority',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'due_date' => 'datetime',
    ];

    // Para la paginación, cuántos mostraremos por página
    protected $perPage = 5;

    // Método de Laravel que se ejecuta cuando se instancia un modelo
    // protected static function boot()
    // {
    //     parent::boot();
    //     //callback que recupera el id del autor y lo
    //     // relaciona con el user_id=> no es un campo rellenable
    //     // se rellena automáticamente con el id del usuario identificado
    //     //Sólo se ejecutará si no estamos lanzando una operación desde consola,
    //     //porque no tenemos el usuario identificado
    //     if(!app()->runningInConsole())
    //     {
    //         self::creating(function (Task $task)
    //         {
    //             $task->user_id = auth()->id();
    //         });
    //     }
    // }

    // Relación muchos a uno, para saber a qué usuario pertenece la tarea
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relación muchos a uno, a qué categoría pertenece la tarea (puedes personalizar según tus necesidades)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Poner la hora en formato legible para nosotros
    // Carbon es una librería para trabajar con fechas
    public function getCreatedAtFormattedAttribute(): string
    {
        return \Carbon\Carbon::parse($this->creation_date)->format('d-m-Y H:i');
    }

    // Accesor para obtener un extracto de la descripción de la tarea
    public function getExcerptAttribute(): string
    {
        return Str::words(value: $this->description, words: 100);
    }
}
