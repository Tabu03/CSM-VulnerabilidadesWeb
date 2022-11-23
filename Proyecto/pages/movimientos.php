<!DOCTYPE html>
<?php
session_start();
include '../scripts/ConexionBD.php';
if(!isset($_SESSION["user"])){
    header("location: ../index.php");
}
if(isset($_GET["hidden"])){
    session_destroy();
    header("location: ../index.php");
}
if(isset($_SESSION["LEVEL"])){
    if($_SESSION["LEVEL"]!=1){
        header("location: ../index.php");
    }
}

if(isset($_COOKIE["language"])){
    $lenguaje = (int)$_COOKIE["language"];
        setcookie(time()+3600 *24);
        
        if(isset($_GET["cambiarLanguage"])){
        $lenguaje = (int)$_COOKIE["language"];
        
        if($lenguaje == 1){
            setcookie("language","0");
            header("location:$_SERVER[PHP_SELF]");
            
        }else {
            setcookie("language","1");
            header("location:$_SERVER[PHP_SELF]");
            
        }   
    }
}
    echo "<br><a href='?cambiarLanguage=true'>Cambiar Idioma</a>";
    
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
        if(isset($_GET["cambiar"])){
        $tema = (int)$_COOKIE["temaGNB"];
        
        if($tema == 1){
            setcookie("temaGNB","0");
            header("location:$_SERVER[PHP_SELF]");
            
        }else if($tema == 0){
            setcookie("temaGNB","1");
            header("location:$_SERVER[PHP_SELF]");
        }   
    }
    echo "<br><a href='?cambiar=true'>Cambiar tema</a>";
    
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <link rel="stylesheet" href="../css/movimientos.css">
    <link rel="stylesheet" href="../css/<?php 
        if($tema == 0){
            echo "claro";
        }else{
            echo "oscuro";
        }?>.css" type="text/css" media="all">
</head>

<body>
    <form method="GET" action="" class="cont__log">
        <span class="log__text">User Logged: <?php
        echo $_SESSION["user"];
        ?></span>
        <input type="hidden" name="hidden" value="out">
        <input type="submit" name="LogOut" value="Log out" class="boton boton__log">
    </form>
    <?php
    addCliente('select * from users', $cadenaConexion);
    transacciones('select * from moves', $cadenaConexion);
    ?>
    
    <div class="botones">
        <button class="boton">Añadir cliente</button>
        <button class="boton">Modificar cliente</button>
        <button class="boton">Borrar cliente</button>
    </div>
</body>

</html>

