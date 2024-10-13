<?php

use Model\ActiveRecord;
try {
    // Crear una instancia de PDO para conectarte a la base de datos
    $dsn = 'mysql:host=localhost;dbname=db'; // Data Source Name (DSN)
    $username = 'user2'; // Tu usuario de base de datos
    $password = 'password'; // Tu contraseña

    // Configurar PDO para que use excepciones en caso de error
    $options = array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Configuración opcional para que el fetch devuelva arrays asociativos
        PDO::ATTR_PERSISTENT => false // Conexiones no persistentes para liberar recursos
    );

    // Crear una nueva conexión PDO
    $db = new PDO($dsn, $username, $password, $options);

    // Asignar la conexión a la clase ActiveRecord
    ActiveRecord::setDB($db);

    // Si llega aquí, la conexión fue exitosa
    //echo "Conexión exitosa a la base de datos.";

} catch (PDOException $e) {
    // Manejar errores de conexión
    if (!class_exists('Model\ActiveRecord')) {
        error_log('La clase Model\ActiveRecord no se está cargando correctamente');
    }
    echo "Error: No se pudo conectar a MySQL." . PHP_EOL;
    echo "Error de depuración: " . $e->getMessage() . PHP_EOL;
    exit;
}

?>

