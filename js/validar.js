
function validarCliente(){

    var tipoCliente, nombre, numeroDocumento, telefono, email, direccion, ciudad, expresion;
    tipoCliente=document.getElementById("tipoCliente").value;
    nombre=document.getElementById("nombre").value;
    numeroDocumento=document.getElementById("numeroDocumento").value;
    telefono=document.getElementById("telefono").value;
    email=document.getElementById("email").value;
    direccion=document.getElementById("direccion").value;
    ciudad=document.getElementById("ciudad").value;

    //expresiones regulares para evaluar lo ingresado en email
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;


    if(tipoCliente==""){
        alert("Campo 'Tipo de Cliente' Esta Vacio");
        return false;
    }else if(nombre=="" || nombre.length>40){
        alert("Campo 'Nombre' Esta Vacio o es Muy Largo");
        return false;
    }else if(numeroDocumento==""){
        alert("Campo 'DNI/CUIT' Esta Vacio");
        return false;
    }else if(numeroDocumento.length<8 || numeroDocumento.length>14){
        alert("Campo 'DNI/CUIT' Invalido");
        return false;
    }else if(isNaN(numeroDocumento)){
        alert("Campo 'DNI/CUIT' Contiene Caracteres Invalidos");
        return false;
    }else if(telefono=="" || telefono.length>20){
        alert("Campo 'Telefono' Esta Vacio o es Muy Largo");
        return false;
    }else if (isNaN(telefono)){
        alert("Campo 'Telefono' Contiene Caracteres Invalidos");
        return false;
    }else if(email==""){
        alert("Campo 'E-Mail' Vacio");
        return false;
    /* }else if(email.match(mailformat)){
        alert("Campo 'E-Mail' Es Invalido");
        return false; */
    }else if(direccion=="" || direccion.length>50){
        alert("Campo 'Direccion' Esta Vacio o es Muy Largo");
        return false;
    }else if (ciudad=="" || ciudad.length>25){
        alert("Campo 'Ciudad' Esta Vacio o es Muy Largo");
        return false;
    }

}
function validarClienteModificar(){

    var tipoCliente, nombre, numeroDocumento, telefono, email, direccion, ciudad /* expresion */;
    tipoCliente=document.getElementById("detalletipoCliente").value;
    nombre=document.getElementById("detalleNombre").value;
    numeroDocumento=document.getElementById("detallenumeroDocumento").value;
    telefono=document.getElementById("detalletelefono").value;
    email=document.getElementById("detalleemail").value;
    direccion=document.getElementById("detalledireccion").value;
    ciudad=document.getElementById("detalleciudad").value;

    //expresiones regulares para evaluar lo ingresado en email
    expresion=/\w+@\w+\.+[a-z]/; 


    if(tipoCliente==""){
        alert("Campo 'Tipo de Cliente' Esta Vacio");
        return false;
    }else if(nombre=="" || nombre.length>40){
        alert("Campo 'Nombre' Esta Vacio o es Muy Largo");
        return false;
    }else if(numeroDocumento==""){
        alert("Campo 'DNI/CUIT' Esta Vacio");
        return false;
    }else if(numeroDocumento.length<8 || numeroDocumento.length>14){
        alert("Campo 'DNI/CUIT' Invalido");
        return false;
    }else if(isNaN(numeroDocumento)){
        alert("Campo 'DNI/CUIT' Contiene Caracteres Invalidos");
        return false;
    }else if(telefono=="" || telefono.length>20){
        alert("Campo 'Telefono' Esta Vacio o es Muy Largo");
        return false;
    }else if (isNaN(telefono)){
        alert("Campo 'Telefono' Contiene Caracteres Invalidos");
        return false;
    }else if(email=="" || email.length>50){
        alert("Campo 'E-Mail' Esta Vacio o es Muy Largo");
        return false;
    /* }else if(expresion.test(email)){
        alert("Campo 'E-Mail' Es Invalido");
        return false; */
    }else if(direccion=="" || direccion.length>50){
        alert("Campo 'Direccion' Esta Vacio o es Muy Largo");
        return false;
    }else if (ciudad=="" || ciudad.length>25){
        alert("Campo 'Ciudad' Esta Vacio o es Muy Largo");
        return false;
    }
    

}
function validarReferente(){

    var codigoCliente, nombre, apellido,  telefono, cargo;
    nombre=document.getElementById("nombreReferente").value;
    apellido=document.getElementById("apellidoReferente").value; 
    telefono=document.getElementById("telefonoReferente").value;
    cargo=document.getElementById("cargoReferente").value;
    codigoCliente=document.getElementById("codigoClienteReferente").value;
    

    if(nombre==""){
        alert("Campo 'Nombre' Esta Vacio");
        return false;
     }else if(apellido=="" ){
        alert("Campo 'Apellido' Esta Vacio");
        return false; 
     }else if(codigoCliente=="" ){
            alert("Campo 'Cliente' Esta Vacio");
            return false;
    }else if(telefono=="" ){
        alert("Campo 'Telefono' Esta Vacio");
        return false; 
    }else if(telefono.length<10){ 
            alert("Campo 'Telefono' Es Demasiado Corto");
            return false;
    }else if(isNaN(telefono)){
            alert("Campo 'Telefono' Es Invalido");
            return false;
    
    }else if(cargo==""){ 
        alert("Campo 'Cargo' Esta Vacio");
        return false;
    }
    



}
function validarReferenteMod(){

    var nombre, apellido,  telefono, cargo;
    nombre=document.getElementById("modnombreReferente").value;
    apellido=document.getElementById("modapellidoReferente").value; 
    telefono=document.getElementById("modtelefonoReferente").value;
    cargo=document.getElementById("modcargoReferente").value;
    

    if(nombre==""){
        alert("Campo 'Nombre' Esta Vacio");
        return false;
     }else if(apellido=="" ){
        alert("Campo 'Apellido' Esta Vacio");
        return false; 
    }else if(telefono=="" ){
        alert("Campo 'Telefono' Esta Vacio");
        return false; 
    }else if(telefono.length<10){ 
            alert("Campo 'Telefono' Es Demasiado Corto");
            return false;
    }else if(isNaN(telefono)){
            alert("Campo 'Telefono' Es Invalido");
            return false;
    
    }else if(cargo==""){ 
        alert("Campo 'Cargo' Esta Vacio");
        return false;
    }
    



}
function validarTrabajo(){

    var cliente, tipoTrabajo,  nombre, descripcion, fechaInicial, referente,  importe;
    cliente=document.getElementById("select_clientes").value;
    referente=document.getElementById("select_Referente").value; 
    tipoTrabajo=document.getElementById("select_tipo_trabajo").value;
    nombre=document.getElementById("nombre_corto").value;
    descripcion=document.getElementById("descripcion").value;
    fechaInicial=document.getElementById("fecha_inicio").value;
    importe=document.getElementById("importe").value;

    if(cliente==""){
        alert("Campo 'Cliente' Esta Vacio");
        return false;
     }else if(referente=="" ){
        alert("Campo 'Referente' Esta Vacio");
        return false; 
     }else if(tipoTrabajo=="" ){
        alert("Campo 'Tipo de Trabajo' Esta Vacio");
        return false; 
    }else if(nombre=="" || nombre.length>30){
        alert("Campo 'Nombre Corto' Esta Vacio o Es Demasiado Largo");
        return false;
    }else if(descripcion=="" || descripcion.length>1000){
        alert("Campo 'Descripcion' Vacio o Demasiado Largo");
        return false;
    }else if(fechaInicial==""){ 
        alert("Campo 'Fecha Inicial' Vacio");
        return false;
    }else if(importe!=""){
        if(importe.length>25){ 
            alert("Campo 'Importe' Es Demasiado largo");
            return false;
        }else if(isNaN(importe)){
            alert("Campo 'Importe' Es Invalido");
            return false;
        }
    }



}
function validarTrabajoMod(){

    var tipoTrabajo, nombre, descripcion, fechaInicial, importe;
    tipoTrabajo=document.getElementById("modSelect_tipo_trabajo").value;
    nombre=document.getElementById("modNombre_corto").value;
    descripcion=document.getElementById("modDescripcion").value;
    fechaInicial=document.getElementById("modFecha_inicio").value;
    importe=document.getElementById("modImporte").value;

    
    if(tipoTrabajo==0 || tipoTrabajo=="" ){
        alert("Campo 'Tipo de Trabajo' Esta Vacio");
        return false;
    }else if(nombre=="" || nombre.length>30){
        alert("Campo 'Nombre Corto' Esta Vacio o Es Demasiado Largo");
        return false;
    }else if(descripcion=="" || descripcion.length>1000){
        alert("Campo 'Descripcion' Vacio o Demasiado Largo");
        return false;
    }else if(fechaInicial==""){ 
        alert("Campo 'Fecha Inicial' Vacio");
        return false;
    }else if(isNaN(importe)){
            alert("Campo 'Importe' Es Invalido");
            return false;
    }
}
function validarTrabajoCobro(){

    var  fechaEntrega, importe;
    fechaEntrega=document.getElementById("cobroFecha_entrega").value;
    importe=document.getElementById("cobroImporte").value;

    
    if(fechaEntrega==""){ 
        alert("Campo 'Fecha Inicial' Vacio");
        return false;
    }else if(isNaN(importe)){
            alert("Campo 'Importe' Es Invalido");
        return false;
    }
}



function validarGasto(){

    let  tipoGasto, alias, descripcion, fecha, importe;
    tipoGasto=document.getElementById("tipoGasto").value;
    alias=document.getElementById("alias").value;
    descripcion=document.getElementById("descripcion").value;
    fecha=document.getElementById("fecha").value;
    importe=document.getElementById("importe").value;

    if(tipoGasto==""){
        alert("Campo 'Tipo de Gasto' Esta Vacio");
        return false;
    }else if(alias=="" ||alias.length>50 ){
        alert("Campo 'Alias' Esta Vacio o es Demasiado Largo");
        return false;
    }else if(descripcion=="" || descripcion.length>1000){
        alert("Campo 'Descripcion' Vacio o Demasiado Largo");
        return false;
    }else if(fecha==""){ 
        alert("Campo 'Fecha' Esta Vacio");
        return false;
    }else if(importe.length>25 || importe==""){ 
        alert("Campo 'Importe' Esta Vacio o Es Demasiado largo");
        return false;
    }
}
function validarGastoMod(){

    let  tipoGasto, alias, descripcion, fecha, importe;
    tipoGasto=document.getElementById("modTipoGasto").value;
    alias=document.getElementById("modAlias").value;
    descripcion=document.getElementById("modDescripcion").value;
    fecha=document.getElementById("modFecha").value;
    importe=document.getElementById("modImporte").value;

    if(tipoGasto==""){
        alert("Campo 'Tipo de Gasto' Esta Vacio");
        return false;
    }else if(alias=="" ||alias.length>50 ){
        alert("Campo 'Alias' Esta Vacio o es Demasiado Largo");
        return false;
    }else if(descripcion=="" || descripcion.length>1000){
        alert("Campo 'Descripcion' Vacio o Demasiado Largo");
        return false;
    }else if(fecha==""){ 
        alert("Campo 'Fecha' Esta Vacio");
        return false;
    }else if(importe.length>25 || importe==""){ 
        alert("Campo 'Importe' Esta Vacio o Es Demasiado largo");
        return false;
    }
}