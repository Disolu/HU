<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TarjetaRequest;
use App\Http\Requests\BloqueRequest;
use App\Http\Controllers\Controller;
use App\Core\Repositories\Administrador\BloqueRepo;
use Session;
use Redirect;

class BloqueController extends Controller
{
    private $path = "administrador";
    private $subpath = "tarjetas";
    private $insubpath = "bloquecriterio";
    protected $BloqueRepo;

    public function __construct(BloqueRepo $BloqueRepo)
    {
        $this->BloqueRepo = $BloqueRepo;
    }

    public function index()
    {

        $bloques = $this->BloqueRepo->getBloques();
        return view("{$this->path}.{$this->subpath}.{$this->insubpath}.index", compact('bloques'));
    }

    public function create()
    {
        $tarjetas = $this->BloqueRepo->getTarjetas();
        $bimestres = $this->BloqueRepo->getBimestres();
        return view("{$this->path}.{$this->subpath}.{$this->insubpath}.new", compact('tarjetas','bimestres'));
    }

    public function store(Request $request)
    {
      $bloque = $this->BloqueRepo->SaveBloque($request->all());
      $lastBloque = $this->BloqueRepo->lastBloque();
      $criterio = $request['criterio'];
      $bimestre = $request['bimestre'];

      if($bloque){
        if($criterio and $bimestre){
          //REGISTRO DE TARJETA BLOQUES
          for ($i=0; $i < count($request['tarjeta']) ; $i++) { 
            $data = [
                'idbloque'  => $lastBloque[0]->idbloque,
                'idtarjeta' => $request['tarjeta'][$i],
                'idbimestre'=> $bimestre
            ];
            $this->BloqueRepo->SaveTarjetaBloque($data);
          }
          //REGISTRO DE CRITERIOS EN BLOQUES
          for ($i=0; $i < count($criterio) ; $i++) { 
            $data = [
                'criterio' => $criterio[$i],
                'idbloque' => $lastBloque[0]->idbloque
            ];
            $this->BloqueRepo->SaveCriterio($data);
          }
        }
        else
        {
          Session::flash('message-danger', 'Ocurrio un error al crear el bloque');            
          return redirect()->back();
        }
        Session::flash('message-success', 'Se registro correctamente el bloque y sus criterios');            
        return redirect()->route('bloquenew');
      }
      else{
          Session::flash('message-danger', 'Ocurrio un error al validar el registro');            
          return redirect()->back();
      }
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
