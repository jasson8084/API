<?php

$servidor = "localhost:3307";
$usuario = "root";
$contraseña = "";
$BD = "apiphp";

$conn = mysqli_connect($servidor, $usuario, $contraseña, $BD);

if ($conn->connect_error) {
    die("connxion fallida" . $conn->connect_error);
}
?>
