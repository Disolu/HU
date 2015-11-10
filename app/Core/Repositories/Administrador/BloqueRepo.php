<?php
namespace App\Core\Repositories\Administrador;
use App\Core\Entities\Tarjeta;
use App\Core\Entities\TarjetaBloque;
use App\Core\Entities\Bimestre;
use App\Core\Entities\Bloque;
use App\Core\Entities\TarjetaBloqueCriterio;
use App\Core\Entities\Nivel;
use Auth;

class BloqueRepo {

  public function getBloques()
  {
    return TarjetaBloque::all();
  }

  public function getBimestres()
  {
    return Bimestre::all();
  }

  public function getTarjetas()
  {
    return Tarjeta::orderBy('idnivel','desc')->get();
  }

	public function SaveTarjeta($request)
	{
    return Tarjeta::create([
      'nombre' => $request['nombre'],
      'idnivel' => $request['idnivel'],
      'updated_at' => ''
    ]);
	}
  
  public function SaveTarjetaBloque($request)
  {
    return TarjetaBloque::create([
      'idbloque'   => $request['idbloque'],
      'idtarjeta'  => $request['idtarjeta'],
      'idbimestre' => $request['idbimestre'],
      'usercreate' => Auth::user()->id,
      'updated_at' => ''
    ]);
  }
  
  public function lastBloque()
  {
    return Bloque::orderby('created_at','DESC')->take(1)->get();
  }

  public function SaveBloque($request)
  {
    return Bloque::create([
      'nombre' => $request['nombre'],
      'usercreate' => Auth::user()->id,
      'updated_at' => ''
    ]);
  }
  public function SaveCriterio($data)
  {
    return TarjetaBloqueCriterio::create([
      'criterio' => $data['criterio'],
      'idbloque' => $data['idbloque'],
      'usercreate' => Auth::user()->id,
      'updated_at' => ''
    ]);
  }
}