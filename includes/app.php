<?php 

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../Model/ActiveRecord.php';
// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);