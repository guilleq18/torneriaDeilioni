<?php
// Finalmente, destruir la sesión.
session_start();



if (session_destroy())
{
    session_unset();
    echo('session destruida como ella');
    header("Location: ../login.php");
}else
{
    echo('la sesion no se destruyo');
}


//header("Location: ../login.php");