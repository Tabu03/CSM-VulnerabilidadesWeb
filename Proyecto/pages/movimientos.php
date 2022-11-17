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
    if($_SESSION["LEVEL"]!=2){
        header("location: ../index.php");
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

    ?>
    <table class="table">
        <tr class="table__head">
            <td>ID_Transacción</td>
            <td>ID_Cliente</td>
            <td>Saldo modificado</td>
            <td>Fecha</td>
            <td>Descripción</td>
        </tr>
        <tr class="table__cont">
            <td>sgd</td>
            <td>dfg</td>
            <td>dfg modificado</td>
            <td>dfhf</td>
            <td>dhgf</td>
        </tr>
    </table>
    <div class="botones">
        <button class="boton">Añadir cliente</button>
        <button class="boton">Modificar cliente</button>
        <button class="boton">Borrar cliente</button>
    </div>
</body>

</html>

