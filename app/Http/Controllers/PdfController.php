<?php
namespace App\Http\Controllers;
use App\Core\Repositories\Administrador\ReportesRepo;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Core\Repositories\Matricula\AlumnoMatriculaRepo;
use App\Core\Repositories\Alumno\AlumnoApoderadoRepo;
use App\Http\Controllers\Controller;



class PdfController extends Controller
{
	protected $AlumnoMatriculaRepo;
	protected $AlumnoApoderadoRepo;
	public function __construct(AlumnoMatriculaRepo $AlumnoMatriculaRepo, AlumnoApoderadoRepo $AlumnoApoderadoRepo)
	{
		$this->AlumnoMatriculaRepo = $AlumnoMatriculaRepo;
		$this->AlumnoApoderadoRepo = $AlumnoApoderadoRepo;
	}

	public function compromiso($id, $periodo) 
	{ 
		$matricula = $this->AlumnoMatriculaRepo->getAllDataAlumno($id, $periodo);
		$apoderado = $this->AlumnoApoderadoRepo->getAllDataApoderado($id);
		
		$view = \View::make('pdf.compromiso', compact('matricula','apoderado'))->render();
		$pdf  = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream('invoice');
	}
	public function anexoPreferencial($id, $periodo) 
	{ 
		$matricula = $this->AlumnoMatriculaRepo->getAllDataAlumno($id, $periodo);
		$apoderado = $this->AlumnoApoderadoRepo->getAllDataApoderado($id);
		$view = \View::make('pdf.anexopreferencial', compact('matricula','apoderado'))->render();
		$pdf  = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream('invoice');
	}
		public function anexoEspecial($id, $periodo) 
	{ 
		$matricula = $this->AlumnoMatriculaRepo->getAllDataAlumno($id, $periodo);
		$apoderado = $this->AlumnoApoderadoRepo->getAllDataApoderado($id);
		$view = \View::make('pdf.anexoespecial', compact('matricula','apoderado'))->render();
		$pdf  = \App::make('dompdf.wrapper');
		$pdf->loadHTML($view);
		return $pdf->stream('invoice');
	}




}
