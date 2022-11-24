<!doctype html>
<?php
session_start();
include '../scripts/ConexionBD.php';

if ($_SERVER["REQUEST_METHOD"] == "POST"&&isset($_SESSION["user"])&&!isset($_GET["hidden"])){
    switch (filter_input(INPUT_POST, "nSecreto")){
        case 1:
            ingresarDinero($cadenaConexion);
            break;
        case 2:
            sacarDinero($cadenaConexion);
            break;
    }
    
}
if(!isset($_SESSION["user"])){
    header("location: ../index.php");
}
if(isset($_GET["hidden"])){
    session_destroy();
    header("location: ../index.php");
}
if(isset($_SESSION["LEVEL"])){
    if($_SESSION["LEVEL"]!=2){
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
<html>

<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INICIO</title>
    <link rel="stylesheet" href="../css/inicio.css">
    <link rel="stylesheet" href="../css/<?php 
        if($tema == 0){
            echo "claro";
        }else{
            echo "oscuro";
        }?>.css" type="text/css" media="all">
</head>

<body>
    <div class="container">
    <form method="GET" action="" class="cont__log">
        <span class="log__text">User Logged: <?php
        echo $_SESSION["user"];
        ?></span>
        <input type="hidden" name="hidden" value="out">
        <input type="submit" name="LogOut" value="Log out" class="boton boton__log">
    </form>
        <?php
        if ($_COOKIE["language"]==0){
        echo '<h1 class="encabezado">Bienvenido al Goliath National Bank</h1>
            
        <div class="saldo">
        <table class="saldo__tab">
            <tr>
                <td class="saldo__td--h">Saldo actual</td>
            </tr>
            <tr>
                <td class="saldo__td--b">'.saldoActual($cadenaConexion).'</td>
            </tr>
        </table>
        </div>
        
        <div class="botones">
            <div class="contbtn">
                <button name="Ing" class="btn" id="Ing">Ingresar dinero</button>
                <button name="Sac" class="btn" id="Sac">Sacar dinero</button>
            </div>
        </div>';
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formIng">
        <h1 class="encabezado">¿Cuanto dinero quieres ingresar?</h1>
        <div class="form__contenido">
            <label class="" for="Money">Cantidad</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Sacar">
            </form>';
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formSac">
        <h1 class="encabezado">¿Cuanto dinero quieres retirar?</h1>
        <div class="form__contenido">
            <label class="" for="Monew">Cantidad</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="2">
        <input class="form__btn" type="submit" value="Ingresar">
            </form>';
        
        }else{
        echo '<h1 class="encabezado">Welcome to the Goliath National Bank</h1>
        
        <div class="saldo">
        <table class="saldo__tab">
            <tr>
                <td class="saldo__td--h">Actual balance</td>
            </tr>
            <tr>
                <td class="saldo__td--b">'.saldoActual($cadenaConexion).'</td>
            </tr>
        </table>
        </div>

        <div class="botones">
            <div class="contbtn">
                <button name="Ing" class="btn" id="Ing">Deposit money</button>
                <button name="Sac" class="btn" id="Sac">Withdraw cash</button>
            </div>
        </div>';
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formIng">
        <h1 class="encabezado">How much money do you want to deposit?</h1>
        <div class="form__contenido">
            <label class="" for="Money">Amount</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Deposit">
            </form>';
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formSac">
        <h1 class="encabezado">How much money do you want to withdraw?</h1>
        <div class="form__contenido">
            <label class="" for="Monew">Amount</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="2">
        <input class="form__btn" type="submit" value="Draw">
            </form>';
        
        }

        ?>
    </div>
    <script src="../scripts/inicio.js"></script>
</body>

</html>

