<?php

include 'conexion.php';

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, DELETE, PUT");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        $sql = "SELECT id, name, email FROM user";
        $result = $conn->query($sql);
        $users = array();
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
        $response = $users;
        break;
    case 'POST':
        $sql = "INSERT INTO user (name, email) VALUES 
        ('" . $input["name"] . "', '" . $input["email"] . "')";
        $conn->query($sql);
        $response = array("message" => "Usuario agregado");
        break;
    case 'PUT':
        $sql = "UPDATE user SET name = '" . $input["name"] . "', email = '" . $input["email"] . "' WHERE id = " . $input["id"];
        $conn->query($sql);
        $response = array("message" => "Usuario modificado");
        break;
    // case 'DELETE':
    //     parse_str(file_get_contents("php://input"), $input);
    //     if(isset($input["id"])) {
    //         $sql = "DELETE FROM user WHERE id = " . intval($input["id"]);
    //         if ($conn->query($sql) === TRUE) {
    //             $response = array("message" => "Usuario eliminado con éxito");
    //         } else {
    //             $response = array("error" => "Error al eliminar usuario: " . $conn->error);                }
    //         } else {
    //             $response = array("error" => "ID no proporcionado o no válido");
    //         }
    //     break;
    case 'DELETE':
        $id = $conn->real_escape_string($input["id"]);
        $sql = "DELETE FROM user WHERE id = '$id'";
        $conn->query($sql);
        $response = array("message" => "Usuario eliminado");
        break;
    default:
        http_response_code(405);
        $response = array("message" => "Invalid method");
        break;
}

echo json_encode($response);

$conn->close();
