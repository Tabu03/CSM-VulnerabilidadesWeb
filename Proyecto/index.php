<!DOCTYPE html>
<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'ConexionBD.php';
}
if(isset($_SESSION["user"])){
    header("location: ./pages/inicio.php");
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
