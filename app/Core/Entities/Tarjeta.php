<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarjeta extends Model
{
    use SoftDeletes;
    protected $table = 'tarjeta';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nombre', 
    'idnivel', 
    'usercreate'
    ];

    public function tarjetabloque()
    {
        return $this->hasMany('App\Core\Entities\TarjetaBloque','idtarjeta','idtarjeta');
    }

    public function nivel()
    {
        return $this->belongsTo('App\Core\Entities\Nivel','idnivel','idnivel');
    }
}