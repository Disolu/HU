<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloque extends Model
{
    use SoftDeletes;
    protected $table = 'bloque';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'idbloque', 
    'nombre', 
    'usercreate'
    ];

    public function criterios()
    {
      //return $this->belongsToMany('App\Core\Entities\TarjetaBloqueCriterio', 'idbloque', 'idbloque');
      return $this->hasMany('App\Core\Entities\TarjetaBloqueCriterio', 'idbloque', 'idbloque');
    }
}
