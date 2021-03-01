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
      $('#popInfo').hide(); 
      $("#tabla").DataTable( {
			  language: {
				url: '/js/Spanish.json',
				buttons: {pageLength: { _: "Mostrar %d filas"}}
      },
      //utilizo el ajax para traer los datos directamente del controlador
			ajax: {
				url: "/php/controller.php",
				type: "POST",
				data: {tipo: "traerTrabajosACobrar"},
				dataSrc: ""
			},
			columns: [
		{ data: "codigoTrabajo"}, 
        { data: "codigoCliente"}, 
        { data: "codigoReferente"},
        { data: "descripcion"},
        { data: "fechaEntrega"},
        { data: "nombreReferente"},
        { data: "apellido"},
        { data: "telefono"},
        { data: "cargo"},
		{ data: "tipoTrabajo", sTitle: "Tipo de Trabajo"},
		{ data: "nombre", sTitle: "Cliente"},
		{ data: "nombreCorto",sTitle: "Definición"},
		{ data: "fechaInicio",sTitle: "Fecha de Entrada"},
		{ data: "importe", sTitle: "Importe"},
        { data: null},
      ],
      
			columnDefs: [
        //DEFINO QUE COLUMNAS MOSTRAR Y EN LA 8 ASIGNO LA BOTONERA
        { targets: [0,1,2,3,4,5,6,7,8], visible: false },
        { targets: 14, width:111, orderable: false, searchable: false, 
          //CON ESTO TOMO EL VALOR DE TODA LA FILA SELECCIONADA AL APRETAR EL BOTON
          render: function (data, type, row) {
					data="";
            //GUARDO EN DATA LA SELECCION DE LA FILA Y DEFINO EL BOTON CON EL CUAL YO HAGO LA SELECCION Y LE ASIGNO LA FUNCION PARA RELLENAR EL MODAL 
            data+='<img class="accion accCobrar" title="Cobrar Trabajo" width="40" height="30" border="0" src="/img/cobrar.png"> ';
			data+='<img class="accion accMod" title="Modificar Trabajo" width="25" height="25" border="0" src="/img/edit.png"> ';
            data+='<img class="accion accDel" title="Borrar Trabajo" width="25" height="25" border="0" src="/img/del.png"> ';
            data+='<img class="accion accInfo" title="Detalle de Trabajo" width="25" height="25" border="0" src="/img/ver.png"> ';
					return data;}}
			],
		
    }); 
         //TOMO LOS VALORES QUE RECOJO CON RENDER DE LA TABLA Y LOS ASIGNO A LOS CAMPOS DEL MODAL DE VERCLIENTE
      $( "#tabla tbody" ).on( "click", ".accMod", function() {
      $('#editarTrabajo').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('editarTrabajo');
      $("#codigoTrabajo").val(item.codigoTrabajo);
      $("#modSelect_clientes").val(item.codigoCliente);
      $("#modSelect_Referente").val(item.codigoReferente);
			$("#modSelect_tipo_trabajo").val(item.tipoTrabajo);
			$("#modNombre_corto").val(item.nombreCorto);
      $("#modDescripcion").val(item.descripcion);
      $("#modFecha_inicio").val(item.fechaInicio);
      $("#modFecha_entrega").val(item.fechaEntrega);
      $("#modImporte").val(item.importe);
      
    });
    //RELLENO EL POPUP CON LA INFO DE TRABAJO SELECCIONADO
    $( "#tabla tbody" ).on( "click", ".accInfo", function() {
			var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
			document.getElementById('popInfo').style.display = "block";
      $("#infoCliente").val(item.nombre);
      $("#definicion").val(item.nombreCorto);
      $("#tipotrabajo").val(item.tipoTrabajo);
	  $("#nombreRef").val(item.nombreReferente + ' '+ item.apellido);
      $("#desc").val(item.descripcion);
      $("#fechentrada").val(item.fechaInicio);
      $("#infoTelRef").val(item.telefono);
      $("#fechentrega").val(item.fechaEntrega);
      $("#cargoRef").val(item.cargo);
      $("#infoImporte").val(item.importe);
    });
    //aqui tomo el registro que deseo eliminar
    $( "#tabla tbody" ).on( "click", ".accDel", function() {
      $('#borrarTrabajo').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
		document.getElementById('borrarTrabajo');
		$("#codigoTrabajo").val(item.codigoTrabajo);
		
     
	
    });
    //aqui abrimos el modal para realizar el cobro
        $( "#tabla tbody" ).on( "click", ".accCobrar", function() {
        $('#cobrarTrabajo').modal('show');
        var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
		document.getElementById('cobrarTrabajo');
		$("#codigoTrabajoCobrar").val(item.codigoTrabajo);
		
		});
        
        colocarClientesSelect();
        //lleno el select de clientes
        $("#select_clientes").select2({
        data: array_colocar_clientes,
        width: '100%',
        allowClear: false,
        language: "es"
    });
        //Una vez que selecciono el cliente lleno el select del referente con los cargados para ese cliente  
        $("#select_clientes").change(function(e){
          var select = document.getElementById("select_Referente");
          for (let i = select.options.length; i >= 0; i--) {
            select.remove(i);
          }
          traerReferenteSelect($("#select_clientes").val());
                        
          $("#select_Referente").select2({
          data: array_colocar_referentes,
          width: '100%',
          allowClear: false,
          language: "es"
          });
        });
            
        //funcion para enviar los parametros de los inputs al ajax
        $("#cargar").click(function(e){
              
             if(validarTrabajo()==false){

          }else{ 
            $("#agregarTrabajo").modal('hide');//ocultamos el modal  */
            
            agregarTrabajo($("#select_clientes").val(), $("#select_Referente").val(), $("#select_tipo_trabajo").val(), $("#nombre_corto").val(), $("#descripcion").val(), $("#fecha_inicio").val(), $("#fecha_entrega").val(), $("#importe").val());
            }  
        });
        $("#cambio").click(function(e){
          
          if(validarTrabajoMod()==false){

              }else{ 
              $("#editarTrabajo").modal('hide');//ocultamos el modal  */
                
               modT($("#codigoTrabajo").val(), $("#modNombre_corto").val(), $("#modDescripcion").val(), $("#modFecha_inicio").val(), $("#modFecha_entrega").val(), $("#modImporte").val(), $("#modSelect_tipo_trabajo").val());
                  
              }
          });
        $("#eliminar").click(function(e){
              
              $("#borrarTrabajo").modal('hide');//ocultamos el modal
              
              bajaT($("#codigoTrabajo").val());
          
        });
        $("#cobrar").click(function(e){
              
            if(validarTrabajoCobro()==false){

                }else{ 
                      $("#cobrarTrabajo").modal('hide');//ocultamos el modal
              
                      cobrarTrabajo($("#codigoTrabajoCobrar").val(),$("#cobroFecha_entrega").val(), $("#cobroImporte").val());
                }
        });
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
<section>
  <div class="container-fluid">
  	<div class="row">
	  <div class="col-lg-1 col-sm-1"></div>
      <div class="col-lg-10 page-header">
        <h3>Lista de Trabajos Sin Cobrar</i></h3>
      </div>
      <div class="col-lg-1 col-sm-1"></div>
	</div>
	<div class="row">
	  <div class="col-lg-1 col-sm-1"></div>
      <div class="col-lg-10" style="border-top: 3px double #006a72;border-bottom: 3px double #006a72;
      border-radius:9px;">
       <!--  POPS  -->
       <div class="popup" id="popInfo">
        <div class="popupContent">
          <div class="popform">
            <div class="col-lg-11 col-sm-12"></div>
            <img class="imgclose align-items-center" width="25" height="25" src="/img/close.png" onclick ="document.getElementById('popInfo').style.display='none';">
	          </div>  
            
            
            <table class="table">
                    <thead>
                      <tr>
                        <th>
                          <h3>Detalle Trabajo</h3>
                        </th>
                      </tr>
                    </thead>
                    <tbody style="background-color:014e54;">
                      <tr>
                      <!-- FILA 1 -->
                        <td>Cliente</td>
                        <td>
                          <input style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="infoCliente" > 
                        </td>
                        <td>Tipo</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="tipotrabajo" > 
                        </td>
                        <td>Definición</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="definicion" > 
                        </td>
                      </tr>
                      <!-- FILA 2 -->
                      <tr>
                        <td>Nombre Referente</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="nombreRef" > 
                        </td>
                        <td>Fecha Entrada</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="fechentrada" > 
                        </td>
                        <td>Descripción</td>
                        <td>
                          <textarea style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="desc" ></textarea> 
                        </td>
                      </tr>
                      <tr >
                        <td>Tel. Referente</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="infoTelRef" > 
                        </td>
                        <td>Fecha Entrega</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="fechentrega" > 
                        </td>
                      </tr>
                      <tr>
                        <td>Cargo</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="cargoRef" > 
                        </td>
                        <td>Importe</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="infoImporte" > 
                        </td>
                      </tr>
                      </tbody>
                  </table>
              
          </div>
        </div>
      </div>
    </div> 
    <div class="col-lg-1 col-md-1"></div>
    </div>
    <div class="row" style="margin: 10px 0px;">
		<div class="col-lg-1 col-md-1 "></div>
		<div class="col-md-10" style="border-top: 3px double #006a72;
      border-radius:9px;">
    <button type="button" class="" data-toggle="modal" data-target="#agregarTrabajo">
      Agregar Trabajos
    </button>
    </div>
		<div class="col-lg-1 col-md-1"></div>
	</div>
<br>


<!-- Modal Para Agregar Trabajo--> 

<div id="agregarTrabajo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <img src="/img/Reparacion.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-sm-offset-3">
                 <h4>AGREGAR INGRESO</h4>
                </div>
              </div>
              <div class="form-group">
                <div class="col form-group">
                <label>Seleccionar Cliente</label>
                  <select class="form-control" name="selectClientes" id="select_clientes" required>
                      <option value=""></option>
                  </select>
                </div>
              </div> 
              <div class="form-group">
                <div class="col form-group">
                <label>Seleccionar Referente</label>
                <select class="form-control" name="selectReferente" id="select_Referente" required>
                    <option value=" "></option>
                </select>
              </div>
              </div>
              <div class="form-group">
                <label>Tipo de Trabajo</label>
                <select class="form-control" name="tipoTrabajo" id="select_tipo_trabajo">
                         <option value=""></option>
                         <option value="Reparacion">Reparación</option>
                         <option value="Venta">Venta</option>
                         <option value="Modificacion">Modificación</option>
                         <option value="Recambio">Recambio</option>
                         <option value="Fabricacion">Fabricacion</option>
                 </select>
              </div>
              <div class="form-group">
                <label>Definición</label>
                <input type="text" class="form-control" id="nombre_corto" required>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea name="" class="form-control" id="descripcion" cols="30" rows="10"></textarea>
              </div>
              <div class="form-group">
                <label>Fecha de Admisión</label>
                <input type="date" class="form-control" id="fecha_inicio" required>
              </div>
              <div class="form-group">
                <label>Fecha de Entrega</label>
                <input type="date" class="form-control" id="fecha_entrega" required>
              </div>
              <div class="form-group">
                <label>Importe</label>
                <input type="text" class="form-control" id="importe" required>
              </div>
              </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="cargar" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- Modal Para Modificar Trabajo--> 

<div id="editarTrabajo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <img src="/img/editar.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-sm-offset-3">
                 <h4>MODIFICAR INGRESO</h4>
                </div>
              </div>
              
              <div class="form-group">
                <label>Tipo de Trabajo</label>
                  <select class="form-control" name="tipoTrabajo" id="modSelect_tipo_trabajo" required>
                         <option selected>Seleccionar Tipo de Operación</option>
                         <option value="Reparacion">Reparación</option>
                         <option value="Venta">Venta</option>
                         <option value="Modificacion">Modificación</option>
                         <option value="Recambio">Recambio</option>
                         <option value="Fabricacion">Fabricacion</option>
                  </select>
              </div>
              <div class="form-group">
                <label>Definición</label>
                <input type="text" class="form-control" id="modNombre_corto" required>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea  name="" class="form-control" id="modDescripcion" cols="30" rows="10"></textarea>
              </div>
              <div class="form-group">
                <label>Fecha de Admisión</label>
                <input type="date" class="form-control" id="modFecha_inicio" required>
              </div>
              <div class="form-group">
                <label>Fecha de Entrega</label>
                <input type="date" class="form-control" id="modFecha_entrega" required>
              </div>
              <div class="form-group">
                <label>Importe</label>
                <input type="text"  class="form-control" id="modImporte" required>
              </div>
              </div>
              <input type="text" class="form-control" id="codigoTrabajo" style="visibility: hidden;" required>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="cambio" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
<!-- Modal Para Borrar Ingreso--> 

<div id="borrarTrabajo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
            </div>
            <div class="modal-body">  
                
                
              <div class="row">
                  <div class="col-lg-8 col-sm-offset-3">
                    <img src="/img/danger.png" width="120" height="120"  alt="">
              </div>
                </div>
              <div class="row">
                  <div class="col-lg-8 col-sm-offset-2">
                   <h4>¿ELIMINAR TRBAJO?</h4>
                  </div>
              </div>
              
            </div>
            <input type="text" class="form-control" id="codigoTrabajo" required style="visibility: hidden;">
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Salir">
              <input type="submit" class="btn btn-DANGER" id="eliminar" value="Eliminar">
            </div>
          </form>
        </div>
      </div>
    </div>

    <div id="cobrarTrabajo" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <img src="/img/cobrar.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-sm-offset-3">
                 <h4>COBRAR TRABAJO</h4>
                </div>
              </div>
              <div class="form-group">
                <label>Fecha de Entrega</label>
                <input type="date" class="form-control" id="cobroFecha_entrega" required>
              </div>
              <div class="form-group">
                <label>Importe</label>
                <input type="text"  class="form-control" id="cobroImporte" required>
              </div>
              </div>
              <input type="text" class="form-control" id="codigoTrabajoCobrar"  required>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="cobrar" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>
    <!--datatable-->
    <div class="row" style="margin-bottom: 20px;">
		<div class="col-lg-1 col-sm-1"></div>
		<div class="col-md-10" style="margin: 10px 0px; border-bottom: 3px double #006a72;
    border-radius:9px;">
	  		<table id="tabla" class="table table-bordered"></table>
		</div>
  	</div>
  </div>
</section>
     
</body>
</html>




