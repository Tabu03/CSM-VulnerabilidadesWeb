<!DOCTYPE html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'scripts/ConexionBD.php';
        inicioSesion('select * from users where PASSWORD = sha1("'.$pass.'")&&USER="'.$usuario.'";', $cadenaConexion, $usuario, $pass);
}
if(isset($_SESSION["user"])&&isset($_SESSION["LEVEL"])){
    switch ($_SESSION["LEVEL"]){
        case 1:
                header("location: pages/movimientos.php");
            break;
        case 2:
                header("location: pages/movimientos.php");
            break;
        case 3:
                header("location: pages/inicio.php");
            break;
    }
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Proyecto</title>
        <link rel="stylesheet" href="./css/style.css">
    </head>
    <body>
        <main class="container">
        <section class="form">
        <form method ="POST" action ="
            <?php echo
            $_SERVER["PHP_SELF"];
            ?>">
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
