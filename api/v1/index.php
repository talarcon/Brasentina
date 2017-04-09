<?php
error_reporting(E_ALL | E_STRICT);
require '.././libs/Slim/Slim.php';
require_once 'dbHelper.php';
require 'config.php';

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST');

\Slim\Slim::registerAutoloader();
$app = new \Slim\Slim();
$app = \Slim\Slim::getInstance();
$db = new dbHelper();

//$app->log->setEnabled(true);
$app->config('debug', true);
/**
 * Database Helper Function templates
 */
/*
select(table name, where clause as associative array)
insert(table name, data as associative array, mandatory column names as array)
update(table name, column names as associative array, where clause as associative array, required columns as array)
delete(table name, where clause as array)
*/

// Local 
$app->get('/local', function() { 
    global $db;
    $rows = $db->select("local","id,nombre,calle,numero,latitud,longitud,tipo",array());
    echoResponse(200, $rows);
});

// Beneficio 
$app->get('/beneficio', function() { 
    global $db;
    $rows = $db->select("beneficio","tipo,nombre,descripcion,puntos,experiencia",array());
    echoResponse(200, $rows);
});

// Trivia 
$app->get('/trivia', function() { 
    global $db;
    $rows = $db->select("trivia","id,nombre,pregunta,respuesta,experiencia",array());
    echoResponse(200, $rows);
});

// Checking 
$app->get('/checking', function() { 
    global $db;
    $rows = $db->select("checking","id_local,id_usuario,dia_hora",array());
    echoResponse(200, $rows);
});

// Tip 
$app->get('/tip', function() { 
    global $db;
    $rows = $db->select("tip","id,nombre,descripcion",array());
    echoResponse(200, $rows);
});

/*
// Local 
$app->get('/local/:latitud/:longitud', function($latitud,$longitud) use ($app) { 
    //$data = json_decode($app->request->getBody());
    $condition = array('latitud'=>$latitud, 'longitud'=>$longitud);
    global $db;
    $rows = $db->select("bares","nombre,tipos",$condition);

    echoResponse(200, $rows);
});
*/

function echoResponse($status_code, $response) {
    global $app;
    $app->status($status_code);
    $app->contentType('application/json');
    echo json_encode($response,JSON_NUMERIC_CHECK);
}

$app->run();
?>
