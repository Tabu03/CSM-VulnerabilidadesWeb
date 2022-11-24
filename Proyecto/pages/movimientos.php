<!DOCTYPE html>
<?php
session_start();
include '../scripts/ConexionBD.php';

//Comprobar el numero del formulario de cada boton a la hora de realizar una consulta
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    switch (filter_input(INPUT_POST, "nSecreto")){
        case 1:
            insertar($cadenaConexion);
            break;
        case 2:
            modificar($cadenaConexion);
            break;
        case 3:
            borrar($cadenaConexion);
            break;
    }
    
}

//Comprobar que a inicio sesion
if(!isset($_SESSION["user"])){
    header("location: ../index.php");
}

//Destruir la sesion al pulsar el boton de log out
if(isset($_GET["hidden"])){
    session_destroy();
    header("location: ../index.php");
}

//Comprobar el nivel del usuario
if(isset($_SESSION["LEVEL"])){
    if($_SESSION["LEVEL"]!=1){
        header("location: ../index.php");
    }
}

/**
 * Cookie que comprueba el idioma e imprime la pagina conforme a la la cookie
 */
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
    
   /**
   * Cookie que aplica el tema em base al valor de la cookie
   */
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
    
    
?>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Movimientos</title>
    <link rel="stylesheet" href="../css/movimientos.css">
    <!-- Comprobar el valor de la variable tema para cambiar el tema de la pagina -->
    <link rel="stylesheet" href="../css/<?php 
        if($tema == 0){
            echo "claro";
        }else{
            echo "oscuro";
        }?>.css" type="text/css" media="all">
</head>

<body>
    <a href='?cambiarLanguage=true'>Cambiar Idioma</a>
    <a href='?cambiarTema=true'>Cambiar tema</a>
    <!-- Nombre del usuario logeado y el boton para deslogearse -->
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
        <button class="boton" id="modifyBalance">Client modify</button>
        <button class="boton" id="deleteClient">Erase client</button>
    </div>
    
    <!-- Formulario que aparecera al pulsar el boton de client add -->
    <form action="<?php echo
            $_SERVER["PHP_SELF"];
            ?>" method="POST" class="form" id="formAddC">
        <h1 class="encabezado">Enter a user</h1>
        <div class="form__contenido">
            <label class="user" for="usuario">User</label>
            <input class="input__content" name="usuario" type="text" placeholder="Enter a username" required>
        </div>
        <div class="form__contenido">
            <label class="password" for="password">Password</label>
            <input class="input__content" name="pass" type="password" placeholder="Enter a password" required>
        </div>
        <div class="form__contenido">
            <label class="level" for="level">Level</label>
            <select class="input__content" name="level">
                <option value="1">1</option>
                <option value="2">2</option>
            </select>
        </div>
        <div class="form__contenido">
            <label class="balance" for="number">Balance</label>
            <input class="input__content" name="balance" type="number" placeholder="Enter a balance">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Crear">
    </form>
    
    <!-- Formulario que aparecera al pulsar el boton de client modify -->
    <form action="<?php echo
            $_SERVER["PHP_SELF"];
            ?>" method="POST" class="form" id="formMod">
        <h1 class="encabezado">Modify Balance</h1>
        <div class="form__contenido">
            <label class="" for="UsuarioID">Id</label>
            <input class="input__content" name="usuarioID" type="number">
        </div>
        <div class="form__contenido">
            <label class="" for="saldo">Balance</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="2">
        <input class="form__btn" type="submit" value="Change">
    </form>
    
    <!-- Formulario que aparecera al pulsar el boton de erase client -->
    <form action="<?php echo
            $_SERVER["PHP_SELF"];
            ?>" method="POST" class="form" id="formDel">
        <h1 class="encabezado">Borrar usuario</h1>
        <div class="form__contenido">
            <label class="" for="UsuarioID">Id a borrar</label>
            <input class="input__content" name="usuarioID" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="3">
        <input class="form__btn" type="submit" value="Eliminar">
    </form>
    <script src="../scripts/movimientos.js"></script>
</body>

</html>

