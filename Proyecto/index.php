<!DOCTYPE html>
<?php
session_start();
//Comprobar metodo de peticion del servidor
if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'scripts/ConexionBD.php';
        inicioSesion($cadenaConexion);
}
//Comprobar el user y el level y dependiendo del level te llevara a una pagina u otra
if(isset($_SESSION["user"])&&isset($_SESSION["LEVEL"])){
    switch ($_SESSION["LEVEL"]){
        case 1:
                header("location: pages/movimientos.php");
            break;
        case 2:
                header("location: pages/inicio.php");
            break;
    }
}

if(!isset($_COOKIE["temaGNB"]))
    {
        setcookie("temaGNB","1", time() + 3600 *24);
    }
    //si no es la primera vez que visitamos esa pagina
    else{
        //no olvidar hacer casting a entero
        $tema = (int)$_COOKIE["temaGNB"];
        setcookie(time()+3600 *24);
    }
    
if(!isset($_COOKIE["language"]))
    {
        setcookie("language","1", time() + 3600 *24,"/");
    }
    //si no es la primera vez que visitamos esa pagina
    else{
        //no olvidar hacer casting a entero
        $lenguaje = (int)$_COOKIE["language"];
        setcookie(time()+3600 *24);
    }
?>
<!-- Formulario del login para el inicio de sesión de la aplicación -->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proyecto</title>
        <link rel="stylesheet" href="./css/style.css">
        <link rel="stylesheet" href="./css/oscuro.css" type="text/css" media="all">
    </head>
    <body>
        <main class="container">
        <section class="form">
        <form method ="POST" action ="">
            <p class="form__user">Usuario</p>
            <input id ="usuario" name="usuario" type="text">
            <p class="form__paswd">Contraseña</p>
            <input id="clave" name="clave" type="password">
            <input class="form__btn" type="submit">
        </form>
        </section>
</main>
    </body>
</html>
