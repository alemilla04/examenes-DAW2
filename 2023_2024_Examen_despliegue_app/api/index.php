<?php

require_once(__DIR__ . "/src/funciones.php");


header("Access-Control-Allow-Origin: *");

header("Content-Type: application/json; charset=UTF-8");
//header("Content-Type: text/plain; charset=UTF-8");

header("Access-Control-Allow-Methods: OPTIONS,GET,POST,PUT,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = explode('/', $uri);

//############ PARA COMPROBAR LA URI RECIBIDA
//print_r($uri); //debug
//exir();
//###########################################

$requestMethod = $_SERVER["REQUEST_METHOD"];



if ($uri[1] !== 'empleados') {
    header("HTTP/1.1 404 Not Found");
    exit();
}

// Miramos a ver si hay userid en el endpoint
$userId = null;
if (isset($uri[2])) {
    $userId = (int) $uri[2];
}



switch ($requestMethod) {
    case 'GET':
        if ($userId != null) {
            //-------------------------------
            //Endpoint    /empleados/X
            //-------------------------------
            //Tendria que conectarme a la bbdd para obtener el emepleado con dicho id
            $pdo = conectaDb();
            $empleado = obtenerEmpleadoBBDD($userId);

            if ($empleado == null) {
                header("HTTP/1.1 404 Not Found");
                exit();
            }
            $respuesta = $empleado;
            header("HTTP/1.1 200 OK");
            echo json_encode($respuesta);
            exit();
        } else {
            //-------------------------------
            //Endpoint    /empleados/
            //-------------------------------
            //Pedir la lista de empleados a la bbdd
            $pdo = conectaDb();
            $listaEmpleados = obtenerEmpleadosBBDD();

            //Debug-----
            //print_r($listaEmpleados);
            //------------

            if ($listaEmpleados == null) {
                header("HTTP/1.1 500 Internat Server Error");
                exit();
            }

            $respuesta = $listaEmpleados;
            header("HTTP/1.1 200");
            echo json_encode($respuesta);
            exit();
        }

    case 'POST':

        break;

    case 'DELETE':

        break;
    default:
        header("HTTP/1.1 404 Not Found");
        exit();
}




//file_put_contents("php://stdout", "\nMethod:$requestMethod");
//file_put_contents("php://stdout", "\nLista:$lista");
            //file_put_contents("php://stdout", "\nHOLA4");
