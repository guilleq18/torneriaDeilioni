<!DOCTYPE html>

<?php 
    session_start();
    if(!isset($_SESSION['codigoUsuario'])){
        header("Location: /login.php");
    }
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SGD</title>
     <!--librerias-->
     <link rel="stylesheet" href="css/bootstrap.css">
      <link rel="stylesheet" href="css/jquery.dataTables.min.css">
      <link rel="stylesheet" href="css/select2.min.css">
      <link rel="stylesheet" href="css/table.css">
      <link rel="stylesheet" href="css/prop.css">
      <link rel="stylesheet" href="css/modal.css">
      <script src="js/jquery-3.4.1.min.js"></script>
      <script src="js/bootstrap.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/select2.min.js"></script>
      <script src="js/ajax.js"></script>
      <script src="js/validar.js"></script>
	  
      <script type="text/javascript">
       
     $(document).ready(function(){
   
         
      $("#tabla").DataTable( {
			  language: {
				url: './js/Spanish.json',
				buttons: {pageLength: { _: "Mostrar %d filas"}}
      },
      //utilizo el ajax para traer los datos directamente del controlador
			ajax: {
				url: "/php/controller.php",
				type: "POST",
				data: {tipo: "traerClientes"},
				dataSrc: ""
			},
			columns: [
				{ data: "codigoCliente"},
				{ data: "nombre", sTitle: "Nombre"},
				{ data: "numeroDocumento", sTitle: "DNI/CUIT"},
				{ data: "direccion",sTitle: "Dirección"},
				{ data: "ciudad",sTitle: "Ciudad"},
				{ data: "email", sTitle: "E-mail"},
        { data: "telefono",sTitle: "Teléfono"},
        { data: "tipoCliente",sTitle: "Tipo Cliente"},
				{ data: null}
      ],
      
			columnDefs: [
        //DEFINO QUE COLUMNAS MOSTRAR Y EN LA 8 ASIGNO LA BOTONERA
        { targets:0, visible: false },
        { targets: 8, width:91, orderable: false, searchable: false, 
          //CON ESTO TOMO EL VALOR DE TODA LA FILA SELECCIONADA AL APRETAR EL BOTON
          render: function (data, type, row) {
					data="";
            //GUARDO EN DATA LA SELECCION DE LA FILA Y DEFINO EL BOTON CON EL CUAL YO HAGO LA SELECCION Y LE ASIGNO LA FUNCION PARA RELLENAR EL MODAL 
						data+='<img class="accion accInfo" title="Editar Cliente" width="25" height="25" border="0" src="/img/edit.png"> ';
            data+='<img class="accion accDel" title="Eliminar Cliente" width="25" height="25" border="0" src="/img/del.png"> ';
            data+='<img class="accion accRef" title="Agregar Referente" width="25" height="25" border="0" src="/img/agr.png"> ';
            data+='<img class="accion accVer" title="Ver Referentes" width="25" height="25" border="0" src="/img/ver.png"> ';
					return data;}}
			],
		
    }); 
        


  //TOMO LOS VALORES QUE RECOJO CON RENDER DE LA TABLA Y LOS ASIGNO A LOS CAMPOS DEL MODAL DE VERCLIENTE
    $( "#tabla tbody" ).on( "click", ".accInfo", function() {
      $('#editarCLiente').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('editarCLiente');
      $("#codigoCliente").val(item.codigoCliente);
			$("#detalletipoCliente").val(item.tipoCliente);
			$("#detalleNombre").val(item.nombre);
			$("#detallenumeroDocumento").val(item.numeroDocumento);
			$("#detalletelefono").val(item.telefono);
			$("#detalleemail").val(item.email);
			$("#detalledireccion").val(item.direccion);
      $("#detalleciudad").val(item.ciudad);
     
	
    });
    $( "#tabla tbody" ).on( "click", ".accVer", function() {
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();

      verReferentes(item.codigoCliente);
	
		});
    //borrar cliente 
    $( "#tabla tbody" ).on( "click", ".accDel", function() {
      $('#borrarCliente').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('borrarCliente');
			$("#codigoCliente").val(item.codigoCliente);
		
     
	
    });
    //TRAIGO EL CODIGO DE CLIENTE DEL TABLE PARA AGREGAR REFERENTE
    $( "#tabla tbody" ).on( "click", ".accRef", function() {
      $('#agregarReferente').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('agregarReferente');
			$("#codigoClienteReferente").val(item.codigoCliente);
		
    });
  });
    
     
	
		  
      




        $("#carga").click(function(e){
              
            
            if (validarCliente()==false){

          
          }else{ 

            $("#agregarCLiente").modal('hide');//ocultamos el modal
            
            agregarCliente($("#tipoCliente").val(), $("#nombre").val(), $("#numeroDocumento").val(), $("#telefono").val(), $("#email").val(), $("#direccion").val(), $("#ciudad").val());
          }
        
        });
        $("#cargaReferente").click(function(e){
              
            
              if (validarReferente()==false){
  
            
            }else{  
  
              $("#agregarReferente").modal('hide');//ocultamos el modal
              
              agregarReferentes($("#codigoClienteReferente").val(), $("#nombreReferente").val(), $("#apellidoReferente").val(), $("#telefonoReferente").val(), $("#cargoReferente").val());
            } 
          
          });
        
    
    $("#modificar").click(function(e){
              
            
            if (validarClienteModificar()==false){
 
            
            }else{ 
                $("#editarCLiente").modal('hide');//ocultamos el modal
              
              modCliente($("#codigoCliente").val(), $("#detalletipoCliente").val(), $("#detalleNombre").val(), $("#detallenumeroDocumento").val(), $("#detalletelefono").val(), $("#detalleemail").val(), $("#detalledireccion").val(), $("#detalleciudad").val());
            }
        
          });
          
    
    $("#eliminar").click(function(e){
              
           
  
              $("#borrarCliente").modal('hide');//ocultamos el modal
              
              bajaCliente($("#codigoCliente").val());
          
          });
          
    
    
        
   
 
	</script>

</head>
<nav class="navbar navbar-default">
  <div class="container-fluid"> 
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse-1"> <span class="sr-only">Cambiar navegación</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button></div>
    
    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="index.php" class="active">Inicio</a></li>
        <li class="nav-item dropdown">
        <a style="background: #014e54; color:white;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Clientes
        </a>
        <div style="background: #014e54;" class=" dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
          <ul class="nav navbar-nav">
             <li><a class="active" href="clientes.php">Catalogo Clientes</a></li>
             <li><a class="active" href="referentes.php">Catalogo Referentes</a></li>
          </ul>
        </div>
      </li>
        <li><a href="gastos.php">Gastos</a></li>
       
        
      <li class="nav-item dropdown">
        <a style="background: #014e54; color:white;" class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Ingresos
        </a>
        <div style="background: #014e54;" class=" dropdown-menu " aria-labelledby="navbarDropdownMenuLink">
          <ul class="nav navbar-nav">
             <li><a class="active" href="ingresos.php">Trabajos</a></li>
             <li><a class="active" href="cobrar.php">Cobrar Trabajo</a></li>
          </ul>
        </div>
      </li>
		<li><a href="balances.php">Balances</a></li>
      </ul>
      <ul class="nav navbar-nav navbar-right">
          <li><a href="php/cerrar.php">Cerrar Sesion</a></li>
        </ul>
    </div>
    <!-- /.navbar-collapse --> 
  </div>
  <!-- /.container-fluid --> 
</nav>

<body>
<section >
  <div class="container-fluid">
  	<div class="row">
	  <div class="col-lg-1 col-sm-1"></div>
      <div class="col-lg-10 page-header">
        <h3>Lista de Clientes</i></h3>
      </div>
    </div>
  <div class="col-lg-1 col-sm-1"></div>
    <div class="col-md-10" style="border-top: 3px double #006a72;border-bottom: 3px double #006a72;
      border-radius:9px;">
 
	  <div class="col-lg-1 col-sm-1"></div>
	</div>
	<div class="row">
  <br>
  <br>
	  <div class="col-lg-1 col-sm-1"></div>
      <div class="col-md-10" style="border-top: 3px double #006a72;
      border-radius:9px;">
            <button type="button" class=" " data-toggle="modal" data-target="#agregarCLiente">
              Agregar Cliente
            </button>
      <!--formulario de detalle de cliente-->
      
      </div>
		<div class="col-lg-1 col-md-1"></div>
	</div>
  
    <div class="row" >
		<div class="col-lg-1 col-md-1 "></div>
		<div class="col-md-10">
    

         
        </div>
      </div>
    
          
    <!-- Modal Para Agregar Clientes--> 

    <div id="agregarCLiente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <img src="/img/agregar.png" width="100" height="100"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-MD-offset-3">
                 <h4>AGREGAR CLIENTE</h4>
                </div>
              </div>
              <div class="form-group">
                <div class="col form-group">
                <label>Tipo Cliente</label>
                      <select class="form-control" name="tipoCliente" id="tipoCliente" required>
                          <option selected>Seleccionar Tipo Cliente</option>
                          <option  value="empresa">Empresa</option>
                          <option  value="particular">Particular</option>
                      </select>
                </div>
              </div> 
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombre" required>
              </div>
              <div class="form-group">
                <label>DNI/CUIT</label>
                <input type="email" class="form-control" id="numeroDocumento" required>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="telefono" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="email" required>
              </div>
              <div class="form-group">
                <label>Dirección</label>
                <input class="form-control" id="direccion" required>
              </div>
              <div class="form-group">
                <label>Ciudad</label>
                <input class="form-control" id="ciudad" required>
              </div>
              
              
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="carga" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Para Agregar Referente--> 

    <div id="agregarReferente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-3">
                  <img src="/img/referente.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 col-sm-offset-2">
                 <h4>AGREGAR REFERENTE</h4>
                </div>
              </div>
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="nombreReferente" required>
              </div>
              <div class="form-group">
                <label>Apellido</label>
                <input type="text" class="form-control" id="apellidoReferente" required>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="telefonoReferente" required>
              </div>
              <div class="form-group">
                <label>Cargo</label>
                <input type="text" class="form-control" id="cargoReferente" required>
              </div>
            </div>
            <input type="text" class="form-control" id="codigoClienteReferente" required style="visibility: hidden;">
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="cargaReferente" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!-- Modal Para Editar Referente--> 

    <div id="editarReferente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-3">
                  <img src="/img/referente.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-8 col-sm-offset-2">
                 <h4>AGREGAR REFERENTE</h4>
                </div>
              </div>
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="modnombreReferente" required>
              </div>
              <div class="form-group">
                <label>Apellido</label>
                <input type="text" class="form-control" id="modapellidoReferente" required>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="modtelefonoReferente" required>
              </div>
              <div class="form-group">
                <label>Cargo</label>
                <input type="text" class="form-control" id="modcargoReferente" required>
              </div>
            </div>
            <input type="text" class="form-control" id="codigoReferente" required style="visibility: hidden;">
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="cargaReferente" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>


  <!-- Modal Para Editar Clientes--> 
    <div id="editarCLiente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
                <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
            </div>
            <div class="modal-body">  
              <div class="row">
              <div class="col-lg-4 col-lg-offset-4">
                <img src="/img/editar.png" width="100" height="100"  alt="">
              </div>
            </div>
            <div class="row">
              <div class="col-lg-6 col-sm-offset-3">
               <h4>EDITAR CLIENTE</h4>
              </div>
            </div>

              <div class="form-group">
                <div class="col form-group">
                <label>Tipo Cliente</label>
                      <select class="form-control" name="tipoCliente" id="detalletipoCliente" required>
                          <option selected>Seleccionar Tipo Cliente</option>
                          <option  value="empresa">Empresa</option>
                          <option  value="particular">Particular</option>
                      </select>
                </div>
              </div> 
              <div class="form-group">
                <label>Nombre</label>
                <input type="text" class="form-control" id="detalleNombre" required>
              </div>
              <div class="form-group">
                <label>DNI/CUIT</label>
                <input type="text" class="form-control" id="detallenumeroDocumento" required>
              </div>
              <div class="form-group">
                <label>Teléfono</label>
                <input type="text" class="form-control" id="detalletelefono" required>
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" class="form-control" id="detalleemail" required>
              </div>
              <div class="form-group">
                <label>Dirección</label>
                <input class="form-control" id="detalledireccion" required>
              </div>
              <div class="form-group">
                <label>Ciudad</label>
                <input class="form-control" id="detalleciudad" required>
              </div>
              <input type="text" class="form-control" id="codigoCliente" required style="visibility: hidden;">
              
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="modificar" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
  <!-- Modal Para Borrar Clientes--> 

    <div id="borrarCliente" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
            </div>
            <div class="modal-body">  
                
                
              <div class="row">
                  <div class="col-lg-4 col-lg-offset-4">
                    <img src="/img/danger.png" width="120" height="120"  alt="">
              </div>
                </div>
              <div class="row">
                  <div class="col-lg-8 col-sm-offset-3">
                   <h4>¿ELIMINAR CLIENTE?</h4>
                  </div>
              </div>
              
            </div>
            <input type="text" class="form-control" id="codigoCliente" required style="visibility: hidden;">
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Salir">
              <input type="submit" class="btn btn-DANGER" id="eliminar" value="Eliminar">
            </div>
          </form>
        </div>
      </div>
    </div>

    
    <!--datatable-->
	<div class="row" >
		<div class="col-lg-1 col-sm-1"></div>
		<div class="col-md-10" style="margin: 10px 0px; border-bottom: 3px double #006a72;
    border-radius:9px;">
	  		<table id="tabla" class="table table-bordered"></table>
		</div>
  	</div>
  </div>
</section>



<!-- FOOTER -->
<footer class="text-center" style="background:#f0f0f0 none repeat scroll 0 0;">
<div class="container">
    <div class="row">
      <div class="col-xs-12"  style="padding:6px !important;">
        <p style="margin:0 !important">Desarrollado para Torneria Deilioni por Guillermo Quintela</p>
      </div>
    </div>
  </div> 
</footer>
<!-- / FOOTER --> 
   
          

      
</body>


    
  
</html>




