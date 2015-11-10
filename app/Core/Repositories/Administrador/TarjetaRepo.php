<?php
namespace App\Core\Repositories\Administrador;
use App\Core\Entities\Tarjeta;
use App\Core\Entities\TarjetaBloque;
use App\Core\Entities\Nivel;
use Auth;

class TarjetaRepo {
   
  public function getTarjetas()
  {
    $tarjeta = Tarjeta::all();
    return $tarjeta;
  }

  public function getNiveles()
  {
    $nivel = Nivel::all();
    return $nivel;
  }

	public function SaveTarjeta($request)
	{
    $tarjeta = Tarjeta::create([
      'nombre' => $request['nombre'],
      'idnivel' => $request['idnivel'],
      'updated_at' => ''
    ]);
    return $tarjeta;
	}

  public function deleteTarjeta($id)
  {
    return Tarjeta::where('idtarjeta', $id)->delete();
  }

  public function deleteTarjetaBloque($id)
  {
    return TarjetaBloque::where('idtarjetabloque', $id)->delete();
  }
  
}