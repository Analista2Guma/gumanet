<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\proyectos_model;
use App\proyectosDetalle_model;
use DB;

class recupProyectos_model extends Model {

    public static function returnDataVentas($anio1, $mes1, $anio2, $mes2) {
		$sql_server = new \sql_server();
		$sql_exec;
		$request = Request();
		$json = array();
		$i=0;
		$company_user = Company::where('id',$request->session()->get('company_id'))->first()->id;
		$total1 = $total2 = 0;

		switch ($company_user) {
			case '1':
			$sql_exec = DB::select('call RECUP_VENDOR_MES_AÑO(?, ?, ?, ?)',array($anio1, $anio2, $mes1, $mes2));
				//$sql_exec = "EXEC  ".$anio1.",".$anio2.",".$mes1.",".$mes2;
				
			break;
			case '2':
				return false;
			break;
			case '3':
				return false;
			break;  
			case '4':
				return false;
			break;          
			default:                
				dd("Ups... Al parecer sucedio un error. ". $company->id);
			break;
		}



		//$query = $sql_server->fetchArray($sql_exec,SQLSRV_FETCH_ASSOC);
		$query = json_decode(json_encode($sql_exec), true);
		//dd($query);
		$proyectos = proyectos_model::orderBy('priori', 'asc')->get();
		$dtlles = array();	

		

		foreach ( $proyectos as $proyecto ) {
			$dtlles = proyectosDetalle_model::select('rutas.vendedor','rutas.nombre','rutas.zona')
                ->join('rutas', 'proyectos_rutas.ruta_id', '=', 'rutas.id')
                ->where('proyectos_rutas.proyecto_id', $proyecto['id'])
                ->where('rutas.estado', 1)
                ->get();

			foreach ( $dtlles as $fila ) {
				if( array_search( $fila['nombre'], array_column( $json, 'nombre' ) ) === false) {
					$ruta = $fila['vendedor'];
					$nombre = $fila['nombre'];
					$temp = array_filter( $query, function($item) use($nombre) { return $item['NOMBRE']==$nombre; } );


					$json[$i]['ruta'] 			= $fila['vendedor'];
					$json[$i]['nombre'] 		= $fila['nombre'];
					$json[$i]['groupColumn'] 	= $proyecto['name'];
					$json[$i]['zona'] 			= $fila['zona'];
					$json[$i]['data'] 			= array(
													'mes1' => array(
														'anioActual' => array_sum(array_column(array_filter( $temp, function($item) use($mes1, $anio1) { return $item['nMes']==$mes1 and $item['ANIO']==$anio1; } ),'RECUPERADO')),
														'anioAnterior' => array_sum(array_column(array_filter( $temp, function($item) use($mes1, $anio2) { return $item['nMes']==$mes1 and $item['ANIO']==$anio2; } ),'RECUPERADO'))
													),
													'mes2' => array(
														'anioActual' => array_sum(array_column(array_filter( $temp, function($item) use($mes2, $anio1) { return $item['nMes']==$mes2 and $item['ANIO']==$anio1; } ),'RECUPERADO')),
														'anioAnterior' => array_sum(array_column(array_filter( $temp, function($item) use($mes2, $anio2) { return $item['nMes']==$mes2 and $item['ANIO']==$anio2; } ),'RECUPERADO'))
													),
												);

					$i++;
				}
			}
		}
		//$sql_server->close();
		//dd($json);
		return $json;	
	}

	public static function listarProyectos() {
		return $this->hasMany('App\Models\proyectos_model');
	}
}