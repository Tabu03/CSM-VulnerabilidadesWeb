<?php
$cadenaConexion = 'mysql:dbname=gnb;host=127.0.0.1';

/*
 * funcion inicioSesion(cadena de conexion)
 * conecta a la base de datos y comprueba, si la consulta devuelve alguna
 * fila, significa que encontro el usuario y la contraseña, por lo tanto
 * la sesion comienza
 * 
 */
function inicioSesion($cadenaConexion) {
    $usuario = filter_input(INPUT_POST, "usuario");
    $pass = filter_input(INPUT_POST, "clave");
    $bd = new PDO($cadenaConexion, "root", "");
    $ins=$bd->prepare("select * from users where PASSWORD = sha1(?)&&USER=?");
    $ins->execute(array($pass,$usuario));
    
    if($ins->rowCount()===1) {
        $_SESSION["user"]=$usuario;
        foreach ($ins as $level){
            $_SESSION["LEVEL"]=$level["LEVEL"];
        }
    }
}

function addCliente($cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = 'select * from users';
    $result = $bd->query($ins);
    echo "<table class='table'>";
    if($_COOKIE["language"]==0){
    echo "<tr class='table__head'>
            <td>ID_Cliente</td>
            <td>Nombre_Cliente</td>
            <td>Saldo</td>
        </tr>";
    }
    else{
        echo "<tr class='table__head'>
            <td>ID_Client</td>
            <td>Client_Name</td>
            <td>Balance</td>
        </tr>";
    }
    foreach ($result as $fila){
        echo "<tr class='table__cont'><td>".$fila["ID"]."</td><td>".$fila["USER"]."</td><td>".$fila["SALDO"]."</td></tr>";
    }
    echo "</table>";
}


function transacciones($cadenaConexion) {
    $bd = new PDO($cadenaConexion, "root", "");
    $bd->beginTransaction();
    $ins = 'select * from moves';
    $result = $bd->query($ins);
    echo "<table class='table'>";
    if($_COOKIE["language"]==0){
    echo '<tr class="table__head">
            <td>ID_Transacción</td>
            <td>ID_Cliente</td>
            <td>Saldo modificado</td>
            <td>Fecha</td>
            <td>Descripción</td>
        </tr>';
    }else{
        echo '<tr class="table__head">
            <td>ID_Transaction</td>
            <td>ID_Client</td>
            <td>Account balance</td>
            <td>Date</td>
            <td>Description</td>
        </tr>';
    }
    foreach ($result as $fila){
        echo "<tr class='table__cont'><td>".$fila["ID_TRANS"]."</td><td>".$fila["USER_ID"]."</td><td>".
                $fila["CANTIDAD"]."</td><td>".
                $fila["FECHA"]."</td><td>".
                $fila["MESSAGE"]."</td></tr>";
    }
    echo "</table>";
}

function insertar($cadenaConexion){
	$campos=[filter_input(INPUT_POST, "usuario"),
            filter_input(INPUT_POST, "pass"),
            filter_input(INPUT_POST, "level"),
            filter_input(INPUT_POST, "balance")];
        if($campos[3]==""&&$campos[2]==1){
            $campos[3]=null;
        }
        try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where user=?");
                $select->execute(array($campos[0]));
                
                if ($select->rowCount()==0){
                    $insert=$bd->prepare("insert into users values(ID,?, sha1(?), ?, ?)");
                    $insert->execute(array($campos[0],$campos[1],$campos[2],$campos[3]));
                }
		
		$bd=null;
	}
    catch (Exception $e){
        
    }
}

function borrar($cadenaConexion){
	try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where id=?");
                $select->execute(array(filter_input(INPUT_POST, "usuarioID")));
                if($select->rowCount()>0){
                    foreach ($select as $fila){
                        if ($fila["LEVEL"]==2){
                            $delete=$bd->prepare("delete from users where id=?");
                            $delete->execute(array(filter_input(INPUT_POST, "usuarioID")));
                        }
                    }
                    
                }
		$bd=null;
	}
        catch (Exception $e){
            
    }
}

function modificar($cadenaConexion){
    $post=[filter_input(INPUT_POST, "saldo"),
        filter_input(INPUT_POST, "usuarioID")];
    try{
		$bd=new PDO($cadenaConexion, "root", "");
                $select=$bd->prepare("select * from users where id=?");
                $select->execute(array($post[1]));
                if($select->rowCount()>0){
                    $update=$bd->prepare("update users set saldo=? where ID=?");
                   
                    $update->execute(array($post[0],$post[1]));
                    $bd->commit();
                }
		$bd=null;
	}
        catch (Exception $e){
            
    }
}

function sacarDinero($cadenaConexion){
    $post=[$_SESSION["user"],
        filter_input(INPUT_POST, "saldo")];
    
    $saldoActual=0;
    $id;
    
    $bd=new PDO($cadenaConexion, "root", "");
    $result=$bd->prepare("select * from users where user=?");
    $result->execute(array($post[0]));
    if ($result->rowCount()==1){
        foreach($result as $saldo){
            $saldoActual=$saldo["SALDO"];
            $id=$saldo["ID"];
        }
        if (($saldoActual-$post[1])>=0){
            $select=$bd->prepare("update users set saldo=saldo-? where user=?");
            $select->execute(array($post[1],$post[0]));
            $select=$bd->prepare("insert into moves values(ID_TRANS,?,-?,DATE(NOW()),'Retirada de dinero')");
            $select->execute(array($id,$post[1]));
        }
    }
}



function ingresarDineroPrueba($cadenaConexion){
    $post=[$_SESSION["user"],
        filter_input(INPUT_POST, "saldo")];
    $id;
    
    $bd=new PDO($cadenaConexion, "root", "");
    $result=$bd->prepare("select * from users where user=?");
    $result->execute(array($post[0]));
    if ($result->rowCount()==1){
        foreach($result as $saldo){
            $id=$saldo["ID"];
        }
            $select=$bd->prepare("update users set saldo=saldo+? where user=?");
            $select->execute(array($post[1],$post[0]));
            $select=$bd->prepare("insert into moves values(ID_TRANS,?,?,DATE(NOW()),'Ingreso de dinero')");
            $select->execute(array($id,$post[1]));
        
    }
}