<style>

</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/login.css">  
      
      <link rel="stylesheet" href="css/prop.css">
      <script src="js/jquery-3.4.1.min.js"></script>
      
    <title>SGD</title>
</head>
<body>
    


<!--****************************************FORMULARIO********************************************** -->
<div class="container">
<br><p class="text-center">Sistema de Gestion Deilion</p>
<hr>
<div class="row justify-content-center">
<div class="col-md-6">
<div class="card" >
<header class="card-header">
	<a href="alta_clientes.php" class="float-right btn btn-outline-success mt-1">Registrarse</a>
	<h4 class="card-title mt-2 ">Iniciar Sesión</h4>
</header>
<article class="card-body" >
<form action="php/usuarios.php" method="POST">
	
	<div class=" form-group">
			<label>DNI </label>   
		  	<input type="text" class="form-control" placeholder="" name="dni" id="dni">
	</div> 
		
		<label>Contraseña</label>
		<input type="password" class="form-control" placeholder="" name="pass" id="pass">
   </div> 
   <br> 
    <div class="form-group">
        <button type="submit" class="btn btn-success btn-block"> Entrar  </button>
    </div>      
    <small class="text-muted">Completa los datos y pulsa "entrar" para acceder al sistema.</small>                                          
</form>
</article> 
<div class="border-top card-body text-center">Olvidaste tu contraseña? <a href="rest_contrasena.php">Reestablecer Contraseña!</a></div>
</div> 
</div> 

</div> 
<li>

<li>

</div> 


    
</body>
</html>
