<!doctype html>
<?php
session_start();
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
        <div class="botones">
            <div class="contbtn">
                <button class="btn">Ingresar dinero</button>
                <button class="btn">Sacar dinero</button>
                <button class="btn">Comprobar extracto de la cuenta</button>
            </div>
        </div>';
        }else{
        echo '<h1 class="encabezado">Welcome to the Goliath National Bank</h1>
        <div class="botones">
            <div class="contbtn">
                <button class="btn">Deposit money</button>
                <button class="btn">Withdraw cash</button>
                <button class="btn">Check the cash balance</button>
            </div>
        </div>';
        }
        ?>
    </div>
</body>

</html>

