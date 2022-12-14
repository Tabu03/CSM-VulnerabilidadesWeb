<!doctype html>
<?php
session_start();
include '../scripts/ConexionBD.php';

//El usuario podra ingresar o retirar dinero
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

//Comprobar que se ha iniciado sesion en la aplicacion
if(!isset($_SESSION["user"])){
    header("location: ../index.php");
}

//Eliminar la cookie desde el boton log out
if(isset($_GET["hidden"])){
    session_destroy();
    header("location: ../index.php");
}

//Comprobar el nivel del usuario
if(isset($_SESSION["LEVEL"])){
    if($_SESSION["LEVEL"]!=2){
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
        <a class="cookies" href='?cambiarLanguage=true'>Cambiar Idioma</a>
        <a class="cookies"href='?cambiarTema=true'>Cambiar tema</a>
    <form method="GET" action="" class="cont__log">
        <span class="log__text">User Logged: <?php
        echo $_SESSION["user"];
        ?></span>
        <input type="hidden" name="hidden" value="out">
        <input type="submit" name="LogOut" value="Log out" class="boton boton__log">
    </form>
        <?php
        //Dependiendo de la cookie saldra en un idioma u otro
        if ($_COOKIE["language"]==0){
            
            //Mostrara el saldo y se podra realizar un ingreso o un retiro de dinero
            
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
        
        //Para ingresar dinero
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formIng">
        <h1 class="encabezado">??Cuanto dinero quieres ingresar?</h1>
        <div class="form__contenido">
            <label class="" for="Money">Cantidad</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Sacar">
            </form>';
        
        //Para sacar dinero
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formSac">
        <h1 class="encabezado">??Cuanto dinero quieres retirar?</h1>
        <div class="form__contenido">
            <label class="" for="Monew">Cantidad</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="2">
        <input class="form__btn" type="submit" value="Ingresar">
            </form>';
        
        }else{
            
        //Comprobar el saldo
            
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
        
        //Cambiar el saldo en la base de datos y del usuario (Ingresar dinero)
        
        echo '<form action='.$_SERVER["PHP_SELF"].' method="POST" class="form" id="formIng">
        <h1 class="encabezado">How much money do you want to deposit?</h1>
        <div class="form__contenido">
            <label class="" for="Money">Amount</label>
            <input class="input__content" name="saldo" type="number">
        </div>
        <input class="oculto" name="nSecreto" type="text" value="1">
        <input class="form__btn" type="submit" value="Deposit">
            </form>';
        
        //Cambiar el saldo en la base de datos y del usuario (Sacar dinero)
        
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

