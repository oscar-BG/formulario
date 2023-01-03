<?php
include("conexion.php");
$resultado = array();
$resultado['status'] = false;

$con = conectar();

$operacion = $_POST['op'];
switch ($operacion) {
    case 'registrar_usuario':
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $ciudad = $_POST['ciudad'];
        $rfc = $_POST['rfc'];
        $delito = $_POST['delito'];
        $hora = $_POST['hora'];
        $fecha = $_POST['fecha'];
        $pertenencias = $_POST['pertenencias'];

        $insert = "INSERT INTO usuarios(nombre, apellido, ciudad, rfc, delito, hora, fecha, pertenencias) VALUES ('$nombre','$apellido','$ciudad','$rfc','$delito','$hora','$fecha','$pertenencias')";
        if ($con->query($insert) === true) {
            $resultado['status'] = true;
        } else {
            $resultado['status'] = false;
            $select = "SELECT rfc FROM usuarios WHERE rfc='$rfc'";
            $respuesta = $con->query($select);
            $num_filas = $respuesta->num_rows;

            if ($num_filas > 0) {
                $resultado['mensaje'] = "EXISTE_RFC";
                $resultado['rfc'] = $rfc;
            }

        }
        break;
    case 'buscar_usuarios':
        $resultado['mensaje'] = "Buscar usuarios";
        $select = "SELECT * FROM usuarios";
        $tabla = $con->query($select);

        $num_filas = $tabla->num_rows;
        if ($num_filas > 0) {
            $resultado['status'] = true;

            while ($row = $tabla -> fetch_array()) {
                $resultado['usuarios'][] = array(
                    'nombre' => $row['nombre'],
                    'apellido' => $row['apellido'],
                    'ciudad' => $row['ciudad'],
                    'rfc' => $row['rfc'],
                    'delito' => $row['delito'],
                    'hora' => $row['hora'],
                    'fecha' => $row['fecha'],
                    'pertenencias' => $row['pertenencias']
                );
            }
        } else {
            $resultado['status'] = false;
        }

        break;

    case 'registrar_admin':
        $resultado['mensaje'] = "Registrar admin";

        $clave = "admin2023";
        $hash = hash('sha256', $clave);
        $nombre = 'Adrian';
        $apellido = 'Hernández';
        $usuario = "admin";
        $resultado['clave'] = $hash;

        $insert = "INSERT INTO login(nombre, apellido, clave, usuario) VALUES ('$nombre','$apellido','$hash','$usuario')";

        if ($con->query($insert)) {
            $resultado['status'] = true;
        }

        break;
    case 'ingresar_tablero':
        $usuario = $_POST['usuario'];
        $clave = $_POST['clave'];

        $select = "SELECT usuario FROM login WHERE usuario = '$usuario'";
        $respuesta = $con->query($select);
        $num_filas = $respuesta->num_rows;
        
        if ($num_filas > 0) {
            $clave_encriptada = hash('sha256', $clave);
            $select = "SELECT id, usuario FROM login WHERE usuario = '$usuario' and clave = '$clave_encriptada'";
            $respuesta = $con->query($select);
            $num_filas = $respuesta->num_rows;
            
            $resultado['usuario_existe'] = true;
            if ($num_filas > 0) {
                $row = $respuesta -> fetch_array();
                $resultado['id_usuario'] = $row['id'];
                $resultado['usuario'] = $row['usuario'];
                $resultado['status'] = true;
            }

        } else {
            $resultado['status'] = false;
            $resultado['usuario_existe'] = false;
        }

        break;
    case 'cambiar_logo':
        $imagen64 = $_POST['imagen'];
        $id_usuario = $_POST['id_usuario'];

        $update = "UPDATE login SET logo = '$imagen64' WHERE id = $id_usuario";
        if ($con->query($update)) {
            $resultado['status'] = true;
        } else {
            $resultado['status'] = false;
            $resultado['mensaje'] = 'Error al actualizar imagen';
        }
        break;
    case 'obtener_logo':
        $select = "SELECT logo FROM login where id = 1";
        $respuesta = $con->query($select);
        $num_filas = $respuesta->num_rows;

        if ($num_filas > 0) {
            $row = $respuesta -> fetch_array();
            $resultado['status'] = true;
            $resultado['logo'] = $row['logo'];
        }
        break;
    
    default:
        # code...
        break;
}



echo json_encode($resultado);
