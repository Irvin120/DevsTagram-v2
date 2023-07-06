<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    //estos son los datos que laravel debe de enviar, esto se usa para que laravel antes de enviar los datos sepa que es lo que se esta enviando
    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'user_id'
    ];


    //relacion inversa entre el modelo post y user
    public function user()
    {
        //especificamos que tipos de datos queremos que cargue
        return $this->belongsTo(User::class)->select(['name', 'username']);
    }

    public function comentarios()
    {
        return $this->hasMany(Comentario::class);
    }
}
