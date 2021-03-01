<style>
[class*="col-md-1"] {
  padding-top: 1rem;
  padding-bottom: 1rem;
  background-color: rgba(73, 146, 83, 0.192);
  border: 1px solid rgba(86,61,124,.2);
}
</style>

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
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.css">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.js"></script>
      <script src="js/jquery-3.4.1.min.js"></script>
     <script src="js/bootstrap.js"></script>
      <script src="js/jquery.dataTables.min.js"></script>
      <script src="js/select2.min.js"></script>
      <script src="js/ajax.js"></script>
      
    <script>

$(document).ready(function(){

    $("#contenedor-fluido").hide();
    

$("#grafica").click(function(e){
    
    $("#detI").hide("slow");
    $("detE").hide("slow");
    $("#balance").show("hide");
    $("#graf").show("slow");
    
});
$("#tabla1").click(function(e){

    $("#graf").hide("slow");
    $("detE").hide("slow");
    $("#balance").show("hide");
    $("#detI").show("slow")
    
});
$("#tabla2").click(function(e){
    
    $("#detI").hide("slow");
    $("#graf").hide("slow");
    $("#balance").show("hide");
    $("detE").show("slow");
});
$("#balGeneral").click(function(e){

    $("#detI").hide("slow");
    $("#graf").hide("slow");
    $("detE").show("hide");
    $("#balance").show("slow");


});

    
$("#generar").click(function(e){

    
        //llamo al contenedor con los datos cuando presiono el 
        $("#contenedor-fluido").show("slow");
        
        //mando los valores de los inputs date para traer los datos a mostrar en las tablas y graficos    
        colocarBalanceIngreso($("#fechaInicial").val(), $("#fechaFinal").val());
        colocarBalanceGasto($("#fechaInicial").val(), $("#fechaFinal").val());
        colocarBalanceGeneral($("#fechaInicial").val(), $("#fechaFinal").val());
        colocarBalanceIngEg($("#fechaInicial").val(), $("#fechaFinal").val());  
        var datos =[];
        var datos1=[];
        var datosG=[];
        var datosI=[];
        var datosE=[];
        var balGen=[];
        var ingresoSum;
        var gastoSum;
        //convierto el json a array
        
        

            //imprimo en el label el valor numeral de array convertido desde json
            if (ingresoSum>gastoSum){
                var myJSON =JSON.stringify(array_balance_general);
                var balance ='El balance General es de $'+getNumbersInString(myJSON);
                
                }else if (ingresoSum<gastoSum){
                    var myJSON =JSON.stringify(array_balance_general);
                var balance ='El balance General es de -$'+getNumbersInString(myJSON);
                
                }else if(ingresoSum==0) {
                    var myJSON =JSON.stringify(array_balance_general);
                var balance ='El balance General es de -$'+getNumbersInString(myJSON);
                
                }else if(gastoSum==0) {
                    var myJSON =JSON.stringify(array_balance_general);
                var balance ='El balance General es de $'+getNumbersInString(myJSON);
                
                }
        document.getElementById("montoFinal").innerHTML = balance;
        
       //SACA LOS NUMEROS DEL JSON array_balance_general
        function getNumbersInString(string) {
                var tmp = string.split("");
                var map = tmp.map(function(current) {
                    if (!isNaN(parseInt(current))) {
                    return current;
                    }
                });

                var numbers = map.filter(function(value) {
                    return value != undefined;
                });

                return numbers.join("");
                };



        //coloco los montos de los ingresos para mostrar en el grafico de ingresos
        for (var i = 0, len = array_balance_ingreso.length; i < len; ++i) {
            
            dato = array_balance_ingreso[i].importe;
            
            datos.push(dato);
            ingresoSum=ingresoSum+array_balance_ingreso[i];

        }
        //coloco los datos de ingresos para la tabla de detalles de ingresos
        for (var i = 0, len = array_balance_ingreso.length; i < len; ++i) {
            
            dato = array_balance_ingreso[i];
            
            datosI.push(dato);
        }
        //coloco los montos de los gastos para mostrar en el grafico de gastos
        for (var i = 0, len = array_balance_gasto.length; i < len; ++i){

            dato=array_balance_gasto[i].importe;

            datos1.push(dato);
            gastoSum= gastoSum+array_balance_gasto[i].importe;

        }
        //coloco los datos de gastos para la tabla de detalles de gastos
        for (var i = 0, len = array_balance_gasto.length; i < len; ++i){

            dato=array_balance_gasto[i];

            datosE.push(dato);

        }
        //coloco el array de inportes de ganancias y egresos en datosG
        for (var i = 0, len = array_balance_ingeg.length; i < len; ++i){

            dato=array_balance_ingeg[i].importe;

            datosG.push(dato);


        }
        
        
//grafico de ingresos        
var ctx = document.getElementById('chart');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [ 'Frabricaciones', 'Modificaciones', 'Recambios','Reparaciones','Ventas'],
        datasets: [{
            label: 'Importe en $',
            data: datos,
            backgroundColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)',
                'rgba(0, 95, 194, 1)',
                'rgba(214, 183, 3, 1)',
                'rgba(0, 0, 0, 1)',
                
            ],
            borderColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)',
                'rgba(0, 95, 194, 1)',
                'rgba(214, 183, 3, 1)',
                'rgba(0, 0, 0, 1)',
                
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
//grafico de egresos
var ctx1 = document.getElementById('egresos');
var myChart1 = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['Compras', 'Pagos'],
        datasets: [{
            label: 'Importe en $',
            data: datos1,
            backgroundColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)'
               
            ],
            borderColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)'
                
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
    });
//grafico General
var ctx2 = document.getElementById('gral');
var myChart2 = new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: ['Egresos', 'Ingresos'],
        datasets: [{
            label: 'Importe en $',
            data: datosG,
            backgroundColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)'
               
            ],
            borderColor: [
                'rgba(215, 21, 44, 0.9)',
                'rgba(22, 131, 44, 0.9)'
                
            ],
            borderWidth: 1
        }]
    },
    
});
   /*  $("#tabla").DataTable( {
            language: {
                  url: 'js/Spanish.json'
            },
               data: datosI,
               aoColumns: [
                  { mdata: "tipoTrabajo", sTitle: "Tipo de Trabajo"},
                  { mdata: "importe", sTitle: "Importe"},
                  { mdata: "totalRealizado", sTitle: "Total de Operaciones"}
                 
        ], 
          colocarBalanceIngreso($("#fechaInicial").val(), $("#fechaFinal").val());
        array_balance_ingreso          
        });  */

        $("#tabla").DataTable( {
			  language: {
				url: './js/Spanish.json',
				buttons: {pageLength: { _: "Mostrar %d filas"}}
      },
      //utilizo el ajax para traer los datos directamente del controlador
			ajax: {
				url: "/php/controller.php",
				type: "POST",
				data: {tipo: "traerBalanceIngreso", fechaInicial:$("#fechaInicial").val(), fechaFinal:$("#fechaFinal").val() },
				dataSrc: ""
			},
			columns: [
				
				{ data: "tipoTrabajo", sTitle: "Tipo de Trabajo"},
				{ data: "importe", sTitle: "Importe"},
				{ data: "total",sTitle: "Total de Operaciones"},
				
       
      ],
      
	
		
    });
    
    $("#tablaE").DataTable( {
            language: {
                  url: 'js/Spanish.json'
            },
               data: datosE,
               aoColumns: [
                  { mData: "tipoGasto", sTitle: "Tipo de Trabajo"},
                  { mData: "importe", sTitle: "Importe"},
                  { mData: "TotalRealizado", sTitle: "Total de Operaciones"}
                 
                  
        ]
          
    });
    $("#Limpiar").click(function(e){
              
        $("#tablaE").dataTable().fnDestroy();
        $("#tabla").dataTable().fnDestroy();
          
    });     
  
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
<div class="container-fluid" >
    <div class="row" style="margin: 20px 0px;">
<div class="col-lg-1  col-sm-1"></div>
   <div class="col-md-10">
      <div class="form-row">
		<div class="form-group col-md-2">
		  <label>Fecha Inicio</label>
		  <input type="date" class="form-control input-lg" name="fechaInicial" id="fechaInicial" >
		</div> <!-- form-group end.// -->
		<div class="form-group col-md-2">
		  <label>Fecha de Cierre</label>
		  <input type="date" class="form-control input-lg" name="fechaFinal" id="fechaFinal" >
		    
        </div>
        <label ></label>
        <div class="form-group col-md-2">
		  <input type="button" class="form-control input-lg" value="Generar" name="generar" id="generar" style="margin-top:25px" >
        </div>
        <div class="form-group col-md-2">
		  <input type="button" class="form-control input-lg" value="Limpiar" name="Limpiar" id="Limpiar" style="margin-top:25px" >
		</div>
   </div>
</div>
</div>
</div>
  <div class="container-fluid" id="contenedor-fluido">
    <div class="row" style="margin: 0px 0px;">
		<div class="col-lg-1  col-sm-1"></div>
		<div class="col-md-10">
			<ul class="nav nav-tabs">
			  <li class="active"><a data-toggle="tab" id="grafica"  href="#graf" style="font-size:large;";">Grafica</a></li>
			  <li><a data-toggle="tab" href="#detI" id="tabla1" style="font-size:large;">Detalle Ingresos</a></li>
			  <li><a data-toggle="tab" href="#detE" id="tabla2" style="font-size:large;">Detalle Egresos</a></li>
			  <li><a data-toggle="tab" href="#balance" id="balGeneral" style="font-size:large;">Balance General</a></li>
            </ul>


<div class="tab-content">
    <div id="graf" class="tab-pane fade in active">
                    <div class="col-md-6">
                                <h3>Ingresos</i></h3>
                                    
                                    <br>
                                    <div class="card-body" id="canvas-container" style="width:90%;">

                                        <canvas id="chart" width="400" height="400"></canvas>   

                                    </div>
                    </div>
                    <div class="col-md-6">
                                <h3>Egresos</i></h3>   
                                    <br>
                                    <div class="card-body" id="canvas-container" style="width:90%;">

                                        <canvas id="egresos" width="400" height="400"></canvas>   

                                    </div>
                                    
                    </div>
        </div>
    <div id="detI" class="tab-pane fade">
                   <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-8">
                              <table id="tabla" class="table table-bordered"></table>
                        </div>
    </div>
    <div id="detE" class="tab-pane fade">
                    <div class="col-lg-2 col-md-2 col-sm-2"></div>
                        <div class="col-lg-8">
                            <table id="tablaE" class="table table-bordered"></table>
                        </div>
    </div>
    <div id="menu3" class="tab-pane fade">
                        <div class="col-md-6">
                                <h3>Ingresos</i></h3>
                                    
                                    <br>
                                    <div class="card-body" id="canvas-container" style="width:90%;">

                                        <canvas id="chart" width="400" height="400"></canvas>   

                                    </div>
                        </div>
                        <div class="col-md-6">
                                <h3>Egresos</i></h3>   
                                    <br>
                                    <div class="card-body" id="canvas-container" style="width:90%;">

                                        <canvas id="egresos" width="400" height="400"></canvas>   

                                    </div>
                                    
                        </div>
    </div>
                        
    <div id="balance" class="tab-pane fade ">
                    <div class="col-md-6">
                                <h3>Comparacion Ingresos Egresos</i></h3>
                                    
                                    <br>
                                    <div class="card-body" id="canvas-container" style="width:90%;">

                                        <canvas id="gral" width="400" height="400"></canvas>   

                                    </div>
                    </div>
                    <div class="col-md-6">
                                    <br>
                                    <br>
                                    <br>
                                <div id="card" style="width: 50rem; border: rgba(0.0.0.1) 1px solid">
                                <h2 id="montoFinal"></i></h2>   
                                </div>
                                    
                    </div>
    </div>
</div>
    </div>
  </div>
</div>



            
			   
		
</section>

</body>

    
  
</html>




