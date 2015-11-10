<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TarjetaBloqueCriterio extends Model
{
    use SoftDeletes;
    protected $table = 'tarjetabloque_criterios';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'idbloquecriterio',
    'idbloque', 
    'criterio', 
    'usercreate'
    ];
}
