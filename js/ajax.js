
var array_clientes=[];
var array_trabajos=[];
var array_gastos=[];
var array_balance_ingreso=[];
var array_balance_gasto=[];
var arrayinsert=[];
var array_colocar_clientes=[];
var array_balance_ingeg=[];
var array_balance_general=[];
var array_detalle_cliente=[];
var array_detalle_trabajo=[];
var array_colocar_clientes_mod=[];
var array_detalle_gasto=[];

function colocarClientes(){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'traerClientes'},
	    success:function(data){
            array_clientes=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}
function colocarTrabajos(){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'traerTrabajos'},
	    success:function(data){
            array_trabajos=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}
function colocarGastos(){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'traerGastos'},
	    success:function(data){
            array_gastos=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

} 

function colocarBalanceGasto(fechaInicial, fechaFinal){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'traerBalanceGasto', fechaInicial: fechaInicial, fechaFinal: fechaFinal},
	    success:function(data){
            array_balance_gasto=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}
function colocarBalanceIngreso(fechaInicial, fechaFinal){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'traerBalanceIngreso', fechaInicial: fechaInicial, fechaFinal: fechaFinal},
	    success:function(data){
            array_balance_ingreso=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}
function colocarBalanceIngEg(fechaInicial, fechaFinal){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'colocarBalanceIngEg', fechaInicial: fechaInicial, fechaFinal: fechaFinal},
	    success:function(data){
            array_balance_ingeg=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}
function colocarBalanceGeneral(fechaInicial, fechaFinal){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'colocarBalanceGeneral', fechaInicial: fechaInicial, fechaFinal: fechaFinal},
	    success:function(data){
            array_balance_general=data;
            
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});	

}

function colocarClientesSelect(){
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'selectClientes'},
		success:function(data){
			array_colocar_clientes=data;
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	})
}
function colocarClientesModSelect(codigo){
	console.log(codigo)
	$.ajax({
		url:'php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		data:{tipo:'selectModTrabajos', codigo: codigo},
		success:function(data){
			array_colocar_clientes_mod=data;
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	})
}
	//recibo los parametros del modal 
function agregarCliente(tipoCliente, nombre, numeroDocumento, telefono, email, direccion, ciudad){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'agregarC', tipoCliente: tipoCliente, nombre: nombre, numeroDocumento: numeroDocumento, telefono: telefono, email: email, direccion: direccion, ciudad: ciudad},
		
		success:function(data){
			//pregunto si el estado es ok. 
			if (data.estado=="OK")
			{	//de serlo indico que el cliente se agrego con exito y recargo la pagina
				alert("cliente agregado con exito");
				window.location.href='/clientes.php';
			}else{// de no serlo indico porque
				alert("cliente o empresa ya existen con ese numero de documento");
			}
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function agregarReferentes(codigoClienteReferente, nombreReferente, apellidoReferente, telefonoReferente, cargoReferente){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'agregarReferente', codigoClienteReferente: codigoClienteReferente, nombreReferente:nombreReferente, apellidoReferente: apellidoReferente, telefonoReferente: telefonoReferente, cargoReferente: cargoReferente},
		
		success:function(data){
			//pregunto si el estado es ok. 
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Referente agregado con exito");
				window.location.href='/referentes.php'; 
			}else{// de no serlo indico porque
				alert("El trabajo no pudo ser registrado");
			}
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function agregarT(codigoCliente, codigoReferente, tipoTrabajo, nombreCorto, descripcion, fechaInicio, fechaEntrega, importe){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'agregarTrabajo', codigoCliente: codigoCliente, codigoReferente:codigoReferente, tipoTrabajo: tipoTrabajo, nombreCorto: nombreCorto, descripcion: descripcion, fechaInicio: fechaInicio, fechaEntrega: fechaEntrega,  importe:importe },
		
		success:function(data){
			//pregunto si el estado es ok. 
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("trabajo agregado con exito");
				window.location.href='/ingresos.php';
			}else{// de no serlo indico porque
				alert("El trabajo no pudo ser registrado");
			}
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function agregarTrabajo(codigoCliente, codigoReferente, tipoTrabajo, nombreCorto, descripcion, fechaInicio, fechaEntrega, importe){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'agregarTrabajo', codigoCliente: codigoCliente, codigoReferente:codigoReferente, tipoTrabajo: tipoTrabajo, nombreCorto: nombreCorto, descripcion: descripcion, fechaInicio: fechaInicio, fechaEntrega: fechaEntrega,  importe:importe },
		
		success:function(data){
			//pregunto si el estado es ok. 
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("trabajo agregado con exito");
				window.location.href='/cobrar.php';
			}else{// de no serlo indico porque
				alert("El trabajo no pudo ser registrado");
			}
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function modT(codigoTrabajo, modNombre_corto, modDescripcion, modFecha_inicio, modFecha_entrega, modImporte, modSelect_tipo_trabajo){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'modTrabajo', codigoTrabajo:codigoTrabajo, modNombre_corto: modNombre_corto, modDescripcion: modDescripcion, modFecha_inicio: modFecha_inicio, modFecha_entrega: modFecha_entrega, modImporte: modImporte, modSelect_tipo_trabajo:modSelect_tipo_trabajo},
		
		success:function(data){
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Cambios Realizados con Exito!");
				
			}else{// de no serlo indico porque
				alert("El Trabajo no pudo ser modificado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function cobrarTrabajo(codigoTrabajoCobrar, cobroFecha_entrega, cobroImporte){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'cobroTrabajo', codigoTrabajoCobrar:codigoTrabajoCobrar, cobroFecha_entrega:cobroFecha_entrega, cobroImporte: cobroImporte},
		
		success:function(data){
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("El Trabajo ha sido cobrado con exito!");
				
			}else{// de no serlo indico porque
				alert("El Trabajo no pudo ser cobrado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function bajaTrabajo(codigoTrabajo){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'bajaTrabajo', codigoTrabajo:codigoTrabajo},
		
		success:function(data){
			if (data.estado=="OK")
			{	
				alert("Trabajo Eliminado!");
				window.location.href='/ingresos.php';
			}else{// de no serlo indico porque
				alert("El Trabajo no pudo ser Eliminado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function bajaT(codigoTrabajo){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'bajaTrabajo', codigoTrabajo:codigoTrabajo},
		
		success:function(data){
			if (data.estado=="OK")
			{	
				alert("Trabajo Eliminado!");
				window.location.href='/cobrar.php';
			}else{// de no serlo indico porque
				alert("El Trabajo no pudo ser Eliminado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function agregarGasto(tipoGasto, alias, descripcion, fecha, importe){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'agregarGasto', tipoGasto: tipoGasto, alias: alias, descripcion: descripcion, fecha: fecha, importe: importe},
		
		success:function(data){
			//pregunto si el estado es ok. 
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Egreso agregado con exito");
				window.location.href='/gastos.php';
			}else{// de no serlo indico porque
				alert("El Egreso no pudo ser registrado");
			}
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function detalleCliente (codigoCliente)
{
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		
		data:{tipo:'detalleCliente', codigoCliente: codigoCliente },
		
		success:function(data){
			
			array_detalle_cliente=data;
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});


}
function detalleTrabajo (codigoTrabajo)
{
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		
		data:{tipo:'detalleTrabajo', codigoTrabajo: codigoTrabajo },
		
		success:function(data){
			
			array_detalle_trabajo=data;
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});


}
function modCliente(codigoCliente, detalletipoCliente, detalleNombre, detallenumeroDocumento, detalletelefono, detalleemail, detalledireccion, detalleciudad){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'modCliente', codigoCliente:codigoCliente, detalletipoCliente: detalletipoCliente, detalleNombre: detalleNombre, detallenumeroDocumento: detallenumeroDocumento, detalletelefono: detalletelefono, detalleemail: detalleemail, detalledireccion: detalledireccion, detalleciudad: detalleciudad},
		
		success:function(data){
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Cambios Realizados con Exito!");
				
			}else{// de no serlo indico porque
				alert("El Cliente no pudo ser modificado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function bajaCliente(codigoCliente){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'bajaCliente', codigoCliente:codigoCliente},
		
		success:function(data){
			if (data.estado=="OK")
			{	
				
				alert("Cliente Eliminado con exito!");
				window.location.href='/clientes.php';
			}else{// de no serlo indico porque
				alert("El Cliente no pudo ser Eliminado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function detalleGasto (codigoGasto)
{
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		
		data:{tipo:'detalleGasto', codigoGasto: codigoGasto },
		
		success:function(data){
			
			array_detalle_gasto=data;
			
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});


}
function modGasto(modCodigoGasto, modTipoGasto, modAlias, modDescripcion, modFecha, modImporte){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'modGasto', modCodigoGasto:modCodigoGasto, modTipoGasto:modTipoGasto, modDescripcion: modDescripcion, modAlias: modAlias, modFecha: modFecha, modImporte: modImporte},
		
		success:function(data){
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Cambios Realizados con Exito!");
				
			}else{// de no serlo indico porque
				alert("El Egreso no pudo ser modificado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function modReferentes(codigoReferente, modnombreReferente, modtelefonoReferente, modapellidoReferente, modcargoReferente){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'modReferentes', codigoReferente:codigoReferente, modnombreReferente:modnombreReferente, modapellidoReferente: modapellidoReferente, modtelefonoReferente: modtelefonoReferente, modcargoReferente: modcargoReferente},
		
		success:function(data){
			if (data.estado=="OK")
			{	//de serlo indico que el trabajo se agrego con exito y recargo la pagina
				alert("Cambios Realizados con Exito!");
				
			}else{// de no serlo indico porque
				alert("El Egreso no pudo ser modificado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function bajaGasto(codigoGasto){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'bajaGasto', codigoGasto:codigoGasto},
		
		success:function(data){
			if (data.estado=="OK")
			{	
				alert("Egreso Eliminado con exito!");
				window.location.href='/gastos.php';
			}else{// de no serlo indico porque
				alert("El Egreso no pudo ser Eliminado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function bajaReferente(codigoReferente){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'bajaReferente', codigoReferente:codigoReferente},
		
		success:function(data){
			if (data.estado=="OK")
			{	
				alert("Referente Eliminado con exito!");
				window.location.href='/referentes.php';
			}else{// de no serlo indico porque
				alert("El Referente no pudo ser Eliminado");
			}
				
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
function traerReferenteSelect(codigoCliente){
	
	
	$.ajax({
		url:'/php/controller.php',
		type:'POST',
		async: false,
		dataType:'json',
		//paso a json los datos que recibo de parametro y el ajax los manda a controller
		data:{tipo:'TraerReferente', codigoCliente:codigoCliente},
		
		success:function(data){
			array_colocar_referentes=data;
		},
		error: function (jqXHR, textStatus, errorThrown){
			console.log(jqXHR+" " +textStatus+ " " +errorThrown);
		}
	});
		
}
