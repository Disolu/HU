<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarjetaBloque extends Model
{
    use SoftDeletes;
    protected $table = 'tarjetabloque';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'idtarjetabloque', 
    'idbloque', 
    'idtarjeta', 
    'idbimestre', 
    'usercreate'
    ];

    public function bloque()
    {
      return $this->belongsTo('App\Core\Entities\Bloque','idbloque','idbloque');
    }

    public function bimestre()
    {
      return $this->belongsTo('App\Core\Entities\Bimestre','idbimestre','idbimestre');
    }

    public function tarjeta()
    {
      return $this->belongsTo('App\Core\Entities\Tarjeta','idtarjeta','idtarjeta');
    }
}