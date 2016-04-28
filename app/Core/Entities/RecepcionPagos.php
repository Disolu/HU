<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecepcionPagos extends Model
{
    use SoftDeletes;
    protected $table = 'recepcionpagos';
    protected $dates = ['deleted_at'];
    protected $fillable = [
    'nomcliente'
  
    ];   
}