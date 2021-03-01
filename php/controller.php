
<?php
header('Content-Type: text/html; charset=utf-8');

require_once('modelo/modelo.php');
$modelo=new Modelo();


$tipo=$_POST['tipo'];

if ($tipo=='traerClientes'){

		$result = $modelo->traerCliente();
		echo $result;
	
	}
if ($tipo=='traerBalanceIngreso'){

		$registros['fechaInicial']=$_POST['fechaInicial'];
		$registros['fechaFinal']=$_POST['fechaFinal'];
    	$result = $modelo->traerBalanceIngreso($registros);
	    echo $result;
	
}
if ($tipo=='traerBalanceGasto'){

	$registros['fechaInicial']=$_POST['fechaInicial'];
	$registros['fechaFinal']=$_POST['fechaFinal'];
	$result = $modelo->traerBalanceGasto($registros);
	echo $result;

}
if ($tipo=='colocarBalanceIngEg'){

	$registros['fechaInicial']=$_POST['fechaInicial'];
	$registros['fechaFinal']=$_POST['fechaFinal'];
	$result = $modelo->colocarBalanceIngEg($registros);
	echo $result;

}
if ($tipo=='colocarBalanceGeneral'){

	$registros['fechaInicial']=$_POST['fechaInicial'];
	$registros['fechaFinal']=$_POST['fechaFinal'];
	$result = $modelo->colocarBalanceGeneral($registros);
	echo $result;

}
if ($tipo=='traerTrabajos'){

		$result = $modelo->traerTrabajos();
		echo $result;
	
}
if ($tipo=='traerTrabajosACobrar'){

		$result = $modelo->traerTrabajosACobrar();
		echo $result;
	
}
if ($tipo=='traerGastos'){

		$result = $modelo->traerGastos();
		echo $result;
	
}
if($tipo=='selectClientes'){
		$result = $modelo->traerClienteSelect();
		if(isset($result)){
			echo $result;
		}
}

	
if($tipo=='agregarC')
	{
		$dni=$_POST['numeroDocumento'];
		$resultComparacion = $modelo->consultaRegistros($dni);
		//decodifico el json que devuelve consultaRegistros()
		$array = json_decode($resultComparacion);
		//pregunto si lo que devolvio es igual al dato que estoy mandando
		if($array[0]->numeroDocumento==$dni)
		{
		//de serlo significa que ya existe un registro con ese numero de documento
		$array=new stdClass;
			$array->estado="NO";
			$json=json_encode($array, JSON_FORCE_OBJECT);
			echo $json;

					
		}else { 
			//de no existir procedo a crear el registro solicitado
			$registros['tipoCliente']=$_POST['tipoCliente'];
			$registros['nombre']=$_POST['nombre'];
			$registros['numeroDocumento']=$_POST['numeroDocumento'];
			$registros['telefono']=$_POST['telefono'];
			$registros['email']=$_POST['email'];
			$registros['direccion']=$_POST['direccion'];
			$registros['ciudad']=$_POST['ciudad'];
			
			$result = $modelo->agregarCliente($registros);		
			//genero la bandera para que si se ejecuta el script de arriba se envie la validacion
			$array=new stdClass;
			$array->estado="OK";
			$json=json_encode($array, JSON_FORCE_OBJECT);
			echo $json;
			
			

		}
	}	

if($tipo=="agregarTrabajo"){
	$registros['codigoCliente']=$_POST['codigoCliente'];
	$registros['codigoReferente']=$_POST['codigoReferente'];
	$registros['tipoTrabajo']=$_POST['tipoTrabajo'];
	$registros['nombreCorto']=$_POST['nombreCorto'];
	$registros['descripcion']=$_POST['descripcion'];
	$registros['fechaInicio']=$_POST['fechaInicio'];
	$registros['fechaEntrega']=$_POST['fechaEntrega'];
	$registros['importe']=$_POST['importe'];
	$result = $modelo->agregarTrabajo($registros);
	//pregunto si el registro fue agregado
	if(isset($result)){
		$array=new stdClass;
			$array->estado="OK";
			$json=json_encode($array, JSON_FORCE_OBJECT);
			echo $json;
	}


}
if($tipo=="agregarGasto")
{
	$registros['tipoGasto']=$_POST['tipoGasto'];
	$registros['alias']=$_POST['alias'];
	$registros['descripcion']=$_POST['descripcion'];
	$registros['fecha']=$_POST['fecha'];
	$registros['importe']=$_POST['importe'];
	
	$result = $modelo->agregarGasto($registros);
	//pregunto si el registro fue agregado
	if(isset($result)){
		$array=new stdClass;
			$array->estado="OK";
			$json=json_encode($array, JSON_FORCE_OBJECT);
			echo $json;
	}


}
if($tipo=="agregarReferente")
{
			$registros['codigoCliente']=$_POST['codigoClienteReferente'];
			$registros['nombre']=$_POST['nombreReferente'];
			$registros['apellido']=$_POST['apellidoReferente'];
			$registros['telefono']=$_POST['telefonoReferente'];
			$registros['cargo']=$_POST['cargoReferente'];
			
			$result = $modelo->agregarReferentes($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="detalleCliente")
{
	$registros['codigoCliente']=$_POST['codigoCliente'];
	
	$result = $modelo->detalleCliente($registros);
	if(isset($result)){
		echo $result;
	}
	

}
if($tipo=="modCliente")
{
			$registros['codigoCliente']=$_POST['codigoCliente'];
			$registros['tipoCliente']=$_POST['detalletipoCliente'];
			$registros['nombre']=$_POST['detalleNombre'];
			$registros['numeroDocumento']=$_POST['detallenumeroDocumento'];
			$registros['telefono']=$_POST['detalletelefono'];
			$registros['email']=$_POST['detalleemail'];
			$registros['direccion']=$_POST['detalledireccion'];
			$registros['ciudad']=$_POST['detalleciudad'];
			
			$result = $modelo->modCliente($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="bajaCliente")
{
			$registros['codigoCliente']=$_POST['codigoCliente'];
			
			
			$result = $modelo->bajaCliente($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="detalleTrabajo")
{
	$registros['codigoTrabajo']=$_POST['codigoTrabajo'];
	
	$result = $modelo->detalleTrabajo($registros);
	if(isset($result)){
		echo $result;
	}
	

}
if($tipo=="modTrabajo")
{
			$registros['codigoTrabajo']=$_POST['codigoTrabajo'];
			$registros['nombre']=$_POST['modNombre_corto'];
			$registros['descripcion']=$_POST['modDescripcion'];
			$registros['fechaInicio']=$_POST['modFecha_inicio'];
			$registros['fechaEntrega']=$_POST['modFecha_entrega'];
			$registros['importe']=$_POST['modImporte'];
			$registros['tipoTrabajo']=$_POST['modSelect_tipo_trabajo'];
			
			$result = $modelo->modTrabajo($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="modReferentes")
{
			$registros['codigoReferente']=$_POST['codigoReferente'];
			$registros['modnombreReferente']=$_POST['modnombreReferente'];
			$registros['modapellidoReferente']=$_POST['modapellidoReferente'];
			$registros['modtelefonoReferente']=$_POST['modtelefonoReferente'];
			$registros['modcargoReferente']=$_POST['modcargoReferente'];
			
			$result = $modelo->modReferentes($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="cobroTrabajo")
{
			$registros['codigoTrabajo']=$_POST['codigoTrabajoCobrar'];
			$registros['cobroFecha_entrega']=$_POST['cobroFecha_entrega'];
			$registros['cobroImporte']=$_POST['cobroImporte'];
			
			
			$result = $modelo->cobroTrabajo($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="bajaTrabajo")
{
			$registros['codigoTrabajo']=$_POST['codigoTrabajo'];
			
			
			$result = $modelo->bajaTrabajo($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="bajaReferente")
{
			$registros['codigoReferente']=$_POST['codigoReferente'];
			
			$result = $modelo->bajaReferente($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="detalleGasto")
{
	$registros['codigoGasto']=$_POST['codigoGasto'];
	
	$result = $modelo->detalleGasto($registros);
	if(isset($result)){
		echo $result;
	}
	

}
if($tipo=="modGasto")
{			$registros['codigoGasto']=$_POST['modCodigoGasto'];
			$registros['tipoGasto']=$_POST['modTipoGasto'];
			$registros['alias']=$_POST['modAlias'];
			$registros['descripcion']=$_POST['modDescripcion'];
			$registros['fecha']=$_POST['modFecha'];
			$registros['importe']=$_POST['modImporte'];
			
			
			$result = $modelo->modGasto($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=="bajaGasto")
{
			$registros['codigoGasto']=$_POST['codigoGasto'];
			
			
			$result = $modelo->bajaGasto($registros);		
			if(isset($result)){
				$array=new stdClass;
					$array->estado="OK";
					$json=json_encode($array, JSON_FORCE_OBJECT);
					echo $json;
			}
	

}
if($tipo=='selectModTrabajos'){

	$registros['codigo'] =$_POST['codigo'];
	$result = $modelo->traerClienteSelectMod($registros);
	echo $result;

	
}
if($tipo=='TraerReferente'){

	$registros['codigo'] =$_POST['codigoCliente'];
	$result = $modelo->traerReferentesSelect($registros);
	echo $result;
}
if($tipo=='traerReferentes'){

	$registros['codigo'] =$_POST['codigoCliente'];
	$result = $modelo->traerReferentes($registros);
	echo $result;
}