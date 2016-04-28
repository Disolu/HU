<?php
namespace App\Core\Entities;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumnoMatricula extends Model
{
    use SoftDeletes;
    protected $table = 'alumnomatricula';
    protected $dates = ['deleted_at'];
    protected $primaryKey = 'idalumnomatricula';
    protected $fillable = [
    'idalumno',  
    'idseccion',         
    'idnivel',           
    'idsede',            
    'idgrado',           
    'idperiodomatricula',
    'idpension',
    'vencimiento',
    'idperiodomatricula',
    'idestadomatricula',
    'idtipopension',
    'usercreate'
    ];
    public function seccion()
    {
        return $this->belongsTo('App\Core\Entities\Seccion','idseccion','idseccion');
    }
    public function nivel()
    {
        return $this->belongsTo('App\Core\Entities\Nivel','idnivel','idnivel');
    }
    public function sede()
    {
        return $this->belongsTo('App\Core\Entities\Sede','idsede','idsede');
    }
    public function grado()
    {
        return $this->belongsTo('App\Core\Entities\Grado','idgrado','idgrado');
    }
    public function alumno()
    {
        return $this->belongsTo('App\Core\Entities\Alumno', 'idalumno', 'idalumno');
    }
}
