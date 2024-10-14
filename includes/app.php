<?php 

require 'funciones.php';
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ .'/../includes/PDO.php';
require_once __DIR__ . '/../Model/ActiveRecord.php';
// Conectarnos a la base de datos
use Model\ActiveRecord;
//verificar variable '$db' en database.php
if (!isset($db)) {
    die("Error: No se pudo conectar a la base de datos");
}
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

ActiveRecord::setDB($db);