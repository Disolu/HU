<?php

namespace App\Http\Controllers\Administrador;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\TarjetaRequest;
use App\Http\Controllers\Controller;
use App\Core\Repositories\Administrador\TarjetaRepo;
use App\Core\Repositories\Administrador\TarjetaBloque;
use Session;
use Redirect;

class TarjetasController extends Controller
{
    private $path = "administrador";
    private $subpath = "tarjetas";
    protected $TarjetaRepo;

    public function __construct(TarjetaRepo $TarjetaRepo)
    {
        $this->TarjetaRepo = $TarjetaRepo;
    }

    public function index()
    {

        $tarjetas = $this->TarjetaRepo->getTarjetas();
        return view("{$this->path}.{$this->subpath}.index", compact('tarjetas'));
    }

    public function create()
    {
        $niveles = $this->TarjetaRepo->getNiveles();
        return view("{$this->path}.{$this->subpath}.new", compact('niveles'));
    }

    public function store(Request $request)
    {
        $tarjeta = $this->TarjetaRepo->SaveTarjeta($request->all());
        if($tarjeta){
            Session::flash('message-success', 'Se registro correctamente la tarjeta');            
            return redirect()->route('tarjetabloques');
        }
        else{
            Session::flash('message-danger', 'Ocurrio un error al validar el registro');            
            return redirect()->route('tarjetanew');
        }
    }

    public function show()
    {
        $tarjetas = $this->TarjetaRepo->getTarjetas();
        return view("{$this->path}.{$this->subpath}.list", compact('tarjetas'));
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
        $tarjeta = $this->TarjetaRepo->deleteTarjeta($id);
        if($tarjeta)
        {
            Session::flash('message-success', 'La tarjeta ha sido eliminado');  
            return redirect()->route('tarjetabloques');
        }
        else{
            return redirect()->back()->withInput(); 
        }
    }

    public function bloquedestroy($id)
    {
        $tarjeta = $this->TarjetaRepo->deleteTarjetaBloque($id);
        if($tarjeta)
        {
            Session::flash('message-success', 'El bloque en la tarjeta ha sido eliminado');  
            return redirect()->route('tarjetabloques');
        }
        else{
            return redirect()->back()->withInput(); 
        }
    }

    
}
