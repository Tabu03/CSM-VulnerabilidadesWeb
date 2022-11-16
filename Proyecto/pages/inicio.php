<!doctype html>
<?php
session_start();
if(!isset($_SESSION["user"])){
    header("location: ../index.php");
}
?>
<html>

<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
</head>

<body>
    <form action="<?php
        session_destroy();
        $_SERVER["PHP_SELF"];
    ?>" class="cont__log">
        <span class="log__text">Logeado por: <?php
        echo $_SESSION["user"];
        ?></span>
        <button class="boton boton__log">Log out</button>
    </form>
    <div class="container">
        <h1 class="encabezado">Bienvenido al Goliath National Bank</h1>
        <div class="botones">
            <div class="contbtn">
                <button class="btn">Ingresar dinero</button>
                <button class="btn">Sacar dinero</button>
                <button class="btn">Comprobar extracto de la cuenta</button>
            </div>
            <div class="contbtn">
                <button class="btn">Realizar transferencia</button>
                <button class="btn">Ver últimos movimientos</button>
                <button class="btn">Sacar dinero sin tarjeta</button>
            </div>
        </div>
    </div>
</body>

</html>

