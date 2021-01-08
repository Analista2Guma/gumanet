<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models;
use App\Company;
use App\recupProyectos_model;

class recupProyectos_controller extends Controller
{
	public function __construct() {
		$this->middleware(['auth','roles']);//pagina se carga unicamente cuando se este logeado
  	}

	public function index(Request $request) {
		$this->agregarDatosASession();

		//$rutas = ventasProyectos_model::rutas();
		

        $data = [
            'page' => 'Usuarios',
            'name' =>  'GUMA@NET'
        ];
		
		return view('pages.recupProyectos',$data);
	}

	public function agregarDatosASession() {
		$request = Request();
		$ApplicationVersion = new \git_version();
		$company = Company::where('id',$request->session()->get('company_id'))->first();// obtener nombre de empresa mediante el id de empresa
		$request->session()->put('ApplicationVersion', $ApplicationVersion::get());
		$request->session()->put('companyName', $company->nombre);// agregar nombre de compañia a session[], para obtenert el nombre al cargar otras pagina 
	}

	public function comparateDateRecup(Request $request) {
		$anio1 = $request->input('anio1');
		$mes1 = $request->input('mes1');

		$anio2 = $request->input('anio2');
		$mes2 = $request->input('mes2');

		

		$obj =  recupProyectos_model::returnDataVentas($anio1, $mes1, $anio2, $mes2);
		return response()->json($obj);
	}
    
}
