<!DOCTYPE html>
<?php
session_start();
include '../scripts/ConexionBD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"){
    insertar($cadenaConexion);
}
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
    
    
if(isset($_COOKIE["temaGNB"])){
    //no olvidar hacer casting a entero
        $tema = (int)$_COOKIE["temaGNB"];
        setcookie(time()+3600 *24);
        
        if(isset($_GET["cambiarTema"])){
        $tema = (int)$_COOKIE["temaGNB"];
        
        if($tema == 1){
            setcookie("temaGNB","0");
            header("location:$_SERVER[PHP_SELF]");
            
        }else if($tema == 0){
            setcookie("temaGNB","1");
            header("location:$_SERVER[PHP_SELF]");
        }   
    }
}
    echo "<br><a href='?cambiarTema=true'>Cambiar tema</a>";
    
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
    addCliente($cadenaConexion);
    transacciones($cadenaConexion);
    ?>
    
    <div class="botones">
        <button class="boton" id="clientAdd">Client add</button>
        <button class="boton">Client modify</button>
        <button class="boton">Erase client</button>
    </div>

    <form action="<?php echo
            $_SERVER["PHP_SELF"];
            ?>" method="POST" class="form" id="formAddC">
        <h1 class="encabezado">Enter a user</h1>
        <div class="form__contenido">
            <label class="user" for="">User</label>
            <input class="input__content" name="usuario" type="text" placeholder="Enter a username" required>
        </div>
        <div class="form__contenido">
            <label class="password" for="">Password</label>
            <input class="input__content" name="pass" type="password" placeholder="Enter a password" required>
        </div>
        <div class="form__contenido">
            <label class="level" for="">Level</label>
            <select class="input__content" name="level">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div class="form__contenido">
            <label class="balance" for="">Balance</label>
            <input class="input__content" name="balance" type="number" placeholder="Enter a balance">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Crear">
    </form>
    <script src="../scripts/movimientos.js"></script>
</body>

</html>

