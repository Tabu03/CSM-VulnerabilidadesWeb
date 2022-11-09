<!DOCTYPE html>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST"){
        include 'ConexionBD.php';
}
?>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <form method ="POST" action ="
            <?php echo
            $_SERVER["PHP_SELF"];
            ?>">
            Usuario
            <input id ="usuario" name="usuario" type="text">
            <input id="clave" name="clave" type="password">
            <input type="submit">
        </form>
    </body>
</html>
