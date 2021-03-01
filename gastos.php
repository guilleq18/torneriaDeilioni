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
				url: './js/Spanish.json',
				buttons: {pageLength: { _: "Mostrar %d filas"}}
      },
      //utilizo el ajax para traer los datos directamente del controlador
			ajax: {
				url: "/php/controller.php",
				type: "POST",
				data: {tipo: "traerGastos"},
				dataSrc: ""
			},
			columns: [
        { data: "codigoGasto"},
        { data: "descripcion"},
				{ data: "tipoGasto", sTitle: "Tipo de Egreso"},
        { data: "alias", sTitle: "Alias"},
        { data: "importe",sTitle: "Importe"},
				{ data: "fecha",sTitle: "Fecha"},
				
				{ data: null}
      ],
      createdRow: function( row, data, dataIndex){
				
					
						$(row).addClass('filaRoja');
					
				
			},
      
			columnDefs: [
        //DEFINO QUE COLUMNAS MOSTRAR Y EN LA 8 ASIGNO LA BOTONERA
        { targets:[0,1], visible: false },
        { targets: 6, width:81, orderable: false, searchable: false, 
          //CON ESTO TOMO EL VALOR DE TODA LA FILA SELECCIONADA AL APRETAR EL BOTON
          render: function (data, type, row) {
					data="";
            //GUARDO EN DATA LA SELECCION DE LA FILA Y DEFINO EL BOTON CON EL CUAL YO HAGO LA SELECCION Y LE ASIGNO LA FUNCION PARA RELLENAR EL MODAL 
						data+='<img class="accion accMod" title="Detalle" width="30" height="30" border="0" src="/img/edit.png"> ';
            data+='<img class="accion accDel" title="Detalle" width="30" height="30" border="0" src="/img/del.png"> ';
            data+='<img class="accion accInfo" title="Detalle" width="30" height="30" border="0" src="/img/ver.png"> ';
					
					return data;}}
			],
      
    });

      //TOMO LOS VALORES QUE RECOJO CON RENDER DE LA TABLA Y LOS ASIGNO A LOS CAMPOS DEL MODAL DE VERCLIENTE
    $( "#tabla tbody" ).on( "click", ".accMod", function() {
      $('#editarGasto').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('editarGasto');
      $("#modCodigoGasto").val(item.codigoGasto);
      $("#modAlias").val(item.alias);
      $("#modTipoGasto").val(item.tipoGasto);
			$("#modDescripcion").val(item.descripcion);
			$("#modFecha").val(item.fecha);
			$("#modImporte").val(item.importe);
			
     
	
    });
    $( "#tabla tbody" ).on( "click", ".accInfo", function() {
			var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
			document.getElementById('popInfo').style.display = "block";
			$("#detalleAlias").val(item.alias);
			$("#detalleImporte").val(item.importe);
			$("#detalleDescripcion").val(item.descripcion);
			$("#detalleFecha").val(item.fecha);
			$("#detalleTipoEgreso").val(item.tipoGasto);
			
		});

    $( "#tabla tbody" ).on( "click", ".accDel", function() {
      $('#borrarGasto').modal('show');
      var item = $("#tabla").DataTable().row( $(this).parents('tr') ).data();
      
			document.getElementById('borrarGasto');
			$("#codigoGasto").val(item.codigoGasto);
		
     
	
		});

        //funcion para enviar los parametros de los inputs al ajax
    $("#carga").click(function(e){
            
         /*  if (validarGasto()==false){
            
          }else{  */

            $("#agregarGasto").modal('hide');//ocultamos el modal
            
            agregarGasto($("#tipoGasto").val(), $("#alias").val(), $("#descripcion").val(), $("#fecha").val(), $("#importe").val());
         /*  }   */
        });
        
    $("#modificar").click(function(e){
            
           /*  if (validarGastoMod()==false){
              
            }else{ 
   */
              $("#editarGasto").modal('hide');//ocultamos el modal
              
              modGasto($("#modCodigoGasto").val(), $("#modTipoGasto").val(), $("#modAlias").val(), $("#modDescripcion").val(), $("#modFecha").val(), $("#modImporte").val());
           /*  }   */
    });
    $("#eliminar").click(function(e){
              
              $("#borrarGasto").modal('hide');//ocultamos el modal
              
              bajaGasto($("#codigoGasto").val());
          
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
        <h3>Lista de Egresos</i></h3>
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
            <h3>Información general del Egreso</h3>
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
                        <td>Tipo de Egreso</td>
                        <td>
                          <input style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="detalleTipoEgreso" > 
                        </td>
                        <td>Alias</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="detalleAlias" > 
                        </td>
                        <td>Fecha</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="detalleFecha" > 
                        </td>
                      </tr>
                      <!-- FILA 2 -->
                      <tr>
                        <td>Importe</td>
                        <td>
                          <input  style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="detalleImporte" > 
                        </td>
                        <td>Descripción</td>
                        <td>
                          <textarea style="border:0; color:red;" readonly="readonly" type="text1" class="form-control" id="detalleDescripcion" ></textarea> 
                        </td>
                      </tr>
                      <tr >
                        
                      </tbody>
                  </table>
          </div>
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
    <button type="button" class="" data-toggle="modal" data-target="#agregarGasto">
      Agregar Egreso
    </button>
    
      </div>
		<div class="col-lg-1 col-md-1"></div>
	</div>
<br>
         <!-- Modal Para Agregar Gasto--> 

    <div id="agregarGasto" class="modal fade">
      <div class="modal-dialog">
        <div class="modal-content">
          <form>
            <div class="modal-header">
              <img class="imgclose" width="25" height="25" src="/img/close.png" data-dismiss="modal" aria-hidden="true">
              </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-lg-4 col-lg-offset-4">
                  <img src="/img/pagos.png" width="120" height="120"  alt="">
                </div>
              </div>
              <div class="row">
                <div class="col-lg-7 col-sm-offset-3">
                 <h4>AGREGAR EGRESO</h4>
                </div>
              </div>
              <div class="form-group">
                <div class="col form-group">
                <label>Tipo Egreso</label>
                      <select class="form-control" name="tipoGasto" id="tipoGasto" 
                                    required>
                                    <option selected>Seleccionar Tipo de Egreso</option>
                                    <option value="Pago">Pago </option>
                                    <option value="Compra">Compra</option>
                      </select>
                </div>
              </div> 
              <div class="form-group">
                <label>Alias</label>
                <input type="text" class="form-control" id="alias" required>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea name="" class="form-control" id="descripcion" cols="30" rows="10"></textarea>
              </div>
              <div class="form-group">
                <label>Fecha</label>
                <input type="date" class="form-control" id="fecha" required>
              </div>
              <div class="form-group">
                <label>Importe</label>
                <input type="text" class="form-control" id="importe" required>
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

<!-- Modal Para Editar Gasto--> 
<div id="editarGasto" class="modal fade">
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
               <h4>EDITAR EGRESO</h4>
              </div>
            </div>

              <div class="form-group">
                <div class="col form-group">
                <label>Tipo Egreso</label>
                      <select class="form-control" name="tipoGasto" id="modTipoGasto" 
                                    required>
                                    <option selected>Seleccionar Tipo de Egreso</option>
                                    <option value="Pago">Pago </option>
                                    <option value="Compra">Compra</option>
                      </select>
                </div>
              </div> 
              <div class="form-group">
                <label>Alias</label>
                <input type="text" class="form-control" id="modAlias" required>
              </div>
              <div class="form-group">
                <label>Descripción</label>
                <textarea name="" class="form-control" id="modDescripcion" cols="30" rows="10"></textarea>
              </div>
              <div class="form-group">
                <label>Fecha</label>
                <input type="date" class="form-control" id="modFecha" required>
              </div>
              <div class="form-group">
                <label>Importe</label>
                <input type="text" class="form-control" id="modImporte" required>
              </div>
              
              <input type="text" class="form-control" id="modCodigoGasto" required style="visibility: hidden;">
              
            </div>
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Cerrar">
              <input type="submit" class="btn btn-success" id="modificar" value="Guardar">
            </div>
          </form>
        </div>
      </div>
    </div>

  <!-- Modal Para Borrar Gastos--> 

  <div id="borrarGasto" class="modal fade">
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
                   <h4>¿ELIMINAR EGRESO?</h4>
                  </div>
              </div>
              
            </div>
            <input type="text" class="form-control" id="codigoGasto" required style="visibility: hidden;">
            <div class="modal-footer">
              <input type="button" class="btn btn-default" data-dismiss="modal" value="Salir">
              <input type="submit" class="btn btn-DANGER" id="eliminar" value="Eliminar">
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




