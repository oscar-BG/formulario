<?php
function conectar() {
    $user = "root";
    $pass = "";
    $servidor  = "localhost";
    $db = "formulario";
    $con = mysqli_connect($servidor, $user,$pass, $db) or die("Error al conectar a la base de datos".mysql_error());

    // mysql_select_db($db, $con);

    return $con;
}