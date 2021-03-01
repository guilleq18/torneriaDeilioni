<?php
error_reporting(0);
require_once('db.php');
class Modelo {
    //variable en donde guardo los datos de la conexion
    private $gestorBD;


    public function __construct() {
        //instancio los datos de la conexion en la variable gestorBD
        $this->gestorBD = new db;
    }

    //Traer Usuarios
    public function consultaRegistros ($dni){

        $sql="
        
        declare @dni nvarchar(20)='".$dni."';

        SELECT numeroDocumento FROM clientes where numeroDocumento=@dni;";

        $datos = $this->gestorBD->hacerConsulta($sql);
        
        return $datos;

    }



	public function traerUsuario($_dni, $_pass){
        
        $sql = "
		SET NOCOUNT ON;
		DECLARE @dni nvarchar(20)='".$_dni."';
		DECLARE @Contrasena nvarchar(40)='".$_pass."';
		SET NOCOUNT OFF;

		select codigoUsuario,dni,nombre from usuario where dni=@dni and contrasena=@Contrasena;
		";
        $user = json_decode($this->gestorBD->hacerConsulta($sql), true);
        return $user;
    }
    
    //metodo que realiza la consulta de clientes
    public function traerTrabajosACobrar()
    {
        $sql = "SELECT tr.codigoTrabajo, cl.nombre, cl.codigoCliente, tr.tipoTrabajo, tr.nombreCorto, tr.descripcion, tr.fechaInicio, case when cast(tr.fechaEntrega as nvarchar) <= '1900-01-01' then 'Pendiente' else cast(tr.fechaEntrega as nvarchar) end as fechaEntrega, tr.importe, ref.codigoReferente, ref.nombre as nombreReferente, ref.apellido, ref.telefono, ref.cargo  FROM clientes cl INNER JOIN trabajo tr ON cl.codigoCliente=tr.codigoCliente
        INNER JOIN referente ref on ref.codigoReferente=tr.codigoReferente
        where tr.fechaEntrega<='1900-01-01'; ";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    public function traerCliente()
    {
        $sql = "SELECT * FROM clientes where baja=0; ";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }


    //llenar datatable de trabajos
    public function traerTrabajos()
    {
        $sql = "SELECT tr.codigoTrabajo, cl.nombre, cl.codigoCliente, tr.tipoTrabajo, tr.nombreCorto, tr.descripcion, tr.fechaInicio, tr.fechaEntrega as fechaEntrega, tr.importe, ref.codigoReferente, ref.nombre as nombreReferente, ref.apellido, ref.telefono, ref.cargo  FROM clientes cl INNER JOIN trabajo tr ON cl.codigoCliente=tr.codigoCliente
        INNER JOIN referente ref on ref.codigoReferente=tr.codigoReferente
        where cast(tr.fechaEntrega as nvarchar) > '1900-01-01'";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    //llenar datatable de Gastos
    public function traerGastos()
    {
        $sql = "SELECT * FROM gastos";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    public function traerBalanceIngreso($registros)
    {
        $sql = "  
                DECLARE @fechaInicial date='".$registros['fechaInicial']."';
                DECLARE @fechaFinal date='".$registros['fechaFinal']."';
                
                SELECT tr.tipoTrabajo, sum(tr.importe) as importe, count(tr.tipoTrabajo) as total FROM trabajo tr where fechaEntrega>=@fechaInicial and fechaEntrega<=@fechaFinal and fechaEntrega!='1900-01-01' and importe !=0
                group by tr.tipoTrabajo
                order by tr.tipoTrabajo";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    public function traerBalanceGasto($registros)
    {
        $sql = "  
                DECLARE @fechaInicial date='".$registros['fechaInicial']."';
                DECLARE @fechaFinal date='".$registros['fechaFinal']."';
                
                SELECT gs.tipoGasto, sum(gs.importe) as importe, count(gs.tipoGasto) as TotalRealizado FROM gastos gs
                where gs.fecha>=@fechaInicial and gs.fecha<=@fechaFinal
                group by gs.tipoGasto
                order by gs.tipoGasto";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    public function colocarBalanceIngEg($registros)
    {
        $sql = "  
                DECLARE @fechaInicial date='".$registros['fechaInicial']."';
                DECLARE @fechaFinal date='".$registros['fechaFinal']."';
                
                select importe from (select sum(importe) as importe,'0' as id from gastos
                where fecha>=@fechaInicial and fecha<=@fechaFinal
                union
                select  sum(importe)as importe,'1' as id from trabajo
                where fechaEntrega>=@fechaInicial and fechaEntrega<=@fechaFinal)as t
                order by id";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }
    public function colocarBalanceGeneral($registros)
    {
        $sql = "  
                DECLARE @fechaInicial date='".$registros['fechaInicial']."';
                DECLARE @fechaFinal date='".$registros['fechaFinal']."';
                DECLARE @contador as int;
                
                select @contador=sum(importe) from gastos
                where fecha>=@fechaInicial and fecha<=@fechaFinal
                
                select  sum(importe)-@contador as importe from trabajo
                where fechaEntrega>=@fechaInicial and fechaEntrega<=@fechaFinal";
        //instancio en datos la consulta que se envia al metodo hacerConsulta que me devuelve los datos a mostrar
        $datos = $this->gestorBD->hacerConsulta($sql);
        //retorno la variable datos para poder ser utilizada posteriormente al ser llamado el metodo
        return $datos;
    }


    //insert de clientes
    public function agregarCliente($registros){
  
        $sql="           

            DECLARE @tipoCliente nvarchar(15)='".$registros['tipoCliente']."';
            DECLARE @nombre nvarchar(40)='".$registros['nombre']."';
            DECLARE @numeroDocumento nvarchar(20)='".$registros['numeroDocumento']."';
            DECLARE @telefono nvarchar(20)='".$registros['telefono']."';
            DECLARE @email nvarchar(50)='".$registros['email']."';
            DECLARE @direccion nvarchar(50)='".$registros['direccion']."';
            DECLARE @ciudad nvarchar(25)='".$registros['ciudad']."';
            
            INSERT INTO dbo.clientes (tipoCliente, nombre, numeroDocumento, telefono, email, direccion, ciudad,baja) VALUES(@tipoCliente, @nombre, @numeroDocumento, @telefono, @email, @direccion, @ciudad, 0);";
            
          
       $datos = $this->gestorBD->hacerInsert($sql);
        return $datos;
     }
     public function modCliente($registros){
  
        $sql="           
            DECLARE @codigoCliente int='".$registros['codigoCliente']. "';
            DECLARE @tipoCliente nvarchar(15)='".$registros['tipoCliente']."';
            DECLARE @nombre nvarchar(40)='".$registros['nombre']."';
            DECLARE @numeroDocumento nvarchar(20)='".$registros['numeroDocumento']."';
            DECLARE @telefono nvarchar(20)='".$registros['telefono']."';
            DECLARE @email nvarchar(50)='".$registros['email']."';
            DECLARE @direccion nvarchar(50)='".$registros['direccion']."';
            DECLARE @ciudad nvarchar(25)='".$registros['ciudad']."';
            
            UPDATE dbo.clientes SET tipoCliente=@tipoCliente, nombre=@nombre, numeroDocumento=@numeroDocumento, telefono=@telefono, email=@email, direccion=@direccion, ciudad=@ciudad WHERE codigoCliente=@codigoCliente;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
     public function bajaCliente($registros){
  
        $sql="           
            DECLARE @codigoCliente int='".$registros['codigoCliente']. "';
           
            
            UPDATE dbo.clientes SET baja=1 WHERE codigoCliente=@codigoCliente;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
    //traer clientes para llenar el select de clientes para los trabajos
    public function traerClienteSelect(){
                //con la primera parte de la consulta genero un campo por defecto
		$sql = "SELECT '0' as id, '' as text UNION SELECT cl.codigoCliente  as id,  cl.nombre as text FROM clientes cl
        where cl.baja=0 order by id;";
		$datos = $this->gestorBD->hacerConsulta($sql);
		return $datos;
    }
    public function traerClienteSelectMod($registros){
        //con la primera parte de la consulta genero un campo por defecto
        
        $sql = "
        DECLARE @codigo nvarchar(15)='".$registros['codigo']."';

        select cl.codigoCliente  as id,  cl.nombre as text from trabajo tr 
        inner join clientes cl on cl.codigoCliente=tr.codigoCliente
        where tr.codigoTrabajo=@codigo and cl.baja=0;";
        
        $datos = $this->gestorBD->hacerConsulta($sql);
        return $datos;
    }
    public function traerReferentesSelect($registros){
        //con la primera parte de la consulta genero un campo por defecto
        $sql = "
        
        DECLARE @codigo integer='".$registros['codigo']."';
        
        /* SELECT '0' as id, '' as text UNION  */SELECT codigoReferente as id, nombre as text FROM referente where codigoCliente= @codigo ;";
       $datos = $this->gestorBD->hacerConsulta($sql);
       return $datos;
    }
    public function traerReferentes($registros){
        //con la primera parte de la consulta genero un campo por defecto
        $sql = "
        select cl.nombre, re.codigoReferente, re.nombre as nombreReferente, re.apellido, re.telefono, re.cargo from clientes cl 
        inner join referente re on re.codigoCliente=cl.codigoCliente
        where cl.baja=0
        order by cl.nombre ;";
       $datos = $this->gestorBD->hacerConsulta($sql);
       return $datos;
    }
    public function agregarReferentes($registros){
  
        $sql="           

            DECLARE @codigoCliente int='".$registros['codigoCliente']."';
            DECLARE @nombre nvarchar(50)='".$registros['nombre']."';
            DECLARE @apellido nvarchar(50)='".$registros['apellido']."';
            DECLARE @telefono nvarchar(50)='".$registros['telefono']."';
            DECLARE @cargo nvarchar(50)='".$registros['cargo']."';
       
            
            INSERT INTO dbo.referente (codigoCliente, nombre, apellido, telefono, cargo) VALUES (@codigoCliente, @nombre, @apellido, @telefono, @cargo);";
            
          
       $datos = $this->gestorBD->hacerInsert($sql);
        return $datos;
    }
    public function agregarTrabajo($registros){
  
        $sql="           

            DECLARE @codigoCliente nvarchar(15)='".$registros['codigoCliente']."';
            DECLARE @codigoReferente nvarchar(15)='".$registros['codigoReferente']."';
            DECLARE @tipoTrabajo nvarchar(60)='".$registros['tipoTrabajo']."';
            DECLARE @nombreCorto nvarchar(60)='".$registros['nombreCorto']."';
            DECLARE @descripcion nvarchar(max)='".$registros['descripcion']."';
            DECLARE @fechaInicio date='".$registros['fechaInicio']."';
            DECLARE @fechaEntrega date='".$registros['fechaEntrega']."';
            DECLARE @importe nvarchar(15)='".$registros['importe']."';
            
            INSERT INTO dbo.trabajo (codigoCliente, nombreCorto, descripcion, fechaInicio, fechaEntrega, codigoReferente, tipoTrabajo, importe) VALUES(@codigoCliente, @nombreCorto, @descripcion, @fechaInicio, @fechaEntrega, @codigoReferente, @tipoTrabajo, @importe);";
            
          
       $datos = $this->gestorBD->hacerInsert($sql);
        return $datos;
     }
     public function modTrabajo($registros){
  
        $sql="           
            DECLARE @codigoTrabajo int='".$registros['codigoTrabajo']. "';
            DECLARE @nombre nvarchar(40)='".$registros['nombre']."';
            DECLARE @descripcion nvarchar(max)='".$registros['descripcion']."';
            DECLARE @fechaInicio date='".$registros['fechaInicio']."';
            DECLARE @fechaEntrega date='".$registros['fechaEntrega']."';
            DECLARE @importe nvarchar(50)='".$registros['importe']."';
            DECLARE @tipoTrabajo nvarchar(25)='".$registros['tipoTrabajo']."';
            
            UPDATE dbo.trabajo SET nombreCorto=@nombre, descripcion=@descripcion, fechaInicio=@fechaInicio, fechaEntrega=@fechaEntrega, importe=@importe, tipoTrabajo=@tipoTrabajo  WHERE codigoTrabajo=@codigoTrabajo;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
     public function modReferentes($registros){
  
        $sql="           
            DECLARE @codigoReferente int='".$registros['codigoReferente']. "';
            DECLARE @nombre nvarchar(40)='".$registros['modnombreReferente']."';
            DECLARE @apellido nvarchar(max)='".$registros['modapellidoReferente']."';
            DECLARE @telefono nvarchar(50)='".$registros['modtelefonoReferente']."';
            DECLARE @cargo nvarchar(25)='".$registros['modcargoReferente']."';
            
            UPDATE dbo.referente SET nombre=@nombre, apellido=@apellido, telefono=@telefono, cargo=@cargo WHERE codigoReferente=@codigoReferente;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
    
    public function cobroTrabajo($registros){
 
       $sql="           
           DECLARE @codigoTrabajo int='".$registros['codigoTrabajo']. "';
           DECLARE @fechaEntrega date='".$registros['cobroFecha_entrega']."';
           DECLARE @importe nvarchar(50)='".$registros['cobroImporte']."';
          
           
           UPDATE dbo.trabajo SET fechaEntrega=@fechaEntrega, importe=@importe WHERE codigoTrabajo=@codigoTrabajo;";
           
         
      $datos = $this->gestorBD->hacerCambio($sql);
       return $datos;
    }
     public function bajaTrabajo($registros){
  
        $sql="           
            DECLARE @codigoTrabajo nvarchar(15)='".$registros['codigoTrabajo']. "';
           
            DELETE FROM dbo.trabajo WHERE codigoTrabajo=@codigoTrabajo;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
     public function bajaReferente($registros){
  
        $sql="           
            DECLARE @codigoReferente nvarchar(15)='".$registros['codigoReferente']. "';
           
            DELETE FROM dbo.referente WHERE codigoReferente=@codigoReferente;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
     public function agregarGasto($registros){
  
        $sql="           

            DECLARE @tipoGasto nvarchar(15)='".$registros['tipoGasto']."';
            DECLARE @alias nvarchar(50)='".$registros['alias']."';
            DECLARE @descripcion nvarchar(200)='".$registros['descripcion']."';
            DECLARE @fecha date='".$registros['fecha']."';
            DECLARE @importe nvarchar(25)='".$registros['importe']."';
           
            
            INSERT INTO dbo.gastos (tipoGasto, alias, descripcion, fecha, importe) VALUES(@tipoGasto, @alias, @descripcion, @fecha, @importe);";
            
          
       $datos = $this->gestorBD->hacerInsert($sql);
        return $datos;
     }
     public function detalleCliente($registros){

        $sql="
            DECLARE @id int='".$registros['codigoCliente']."';


            SELECT * FROM dbo.clientes where codigoCliente=@id;";
            $datos=$this->gestorBD->hacerConsulta($sql);
            return $datos;

     }
     public function detalleTrabajo($registros){

        $sql="
            DECLARE @id int='".$registros['codigoTrabajo']."';


            SELECT * FROM dbo.trabajo where codigoTrabajo=@id;";
            $datos=$this->gestorBD->hacerConsulta($sql);
            return $datos;

     }
     public function detalleGasto($registros){

        $sql="
            DECLARE @id int='".$registros['codigoGasto']."';


            SELECT * FROM dbo.gastos where codigoGasto=@id;";
            $datos=$this->gestorBD->hacerConsulta($sql);
            return $datos;

     }
     public function modGasto($registros){
  
        $sql="           
            DECLARE @codigoGasto nvarchar(15)='".$registros['codigoGasto']. "';
            DECLARE @tipoGasto nvarchar(25)='".$registros['tipoGasto']."';
            DECLARE @alias nvarchar(40)='".$registros['alias']."';
            DECLARE @descripcion nvarchar(1000)='".$registros['descripcion']."';
            DECLARE @fecha date='".$registros['fecha']."';
            DECLARE @importe nvarchar(50)='".$registros['importe']."';
            
            UPDATE dbo.gastos SET tipoGasto=@tipoGasto, alias=@alias, descripcion=@descripcion, fecha=@fecha, importe=@importe  WHERE codigoGasto=@codigoGasto;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
     public function bajaGasto($registros){
  
        $sql="           
            DECLARE @codigoGasto nvarchar(15)='".$registros['codigoGasto']. "';
           
            DELETE FROM dbo.gastos WHERE codigoGasto=@codigoGasto;";
            
          
       $datos = $this->gestorBD->hacerCambio($sql);
        return $datos;
     }
}
