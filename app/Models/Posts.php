<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;
    protected $table = 'posts';
    protected $fillable =[
        'categoria_id',
        'titulo',
        'imagen',
        'resumen',
        'estado',
        'tags',
        'fecha_publicacion',
        'usuario_id',
    ];

    //relacion con categorias
    public function categoria(){
        return $this->belongsTo(Categorias::class, 'categoria_id');
    }
    //relacion con usuarios
    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }
    public function getImagenURl(){
        if ($this->imagen && $this->imagen != 'default.png' && $this->imagen != null) {
            return asset('imagenes/posts/'.$this->imagen);
        } else{
            return asset('default.png');
        }
    }
}
