<?php
namespace Model;
use PDO;

class ActiveRecord {

    // Base de Datos
    protected static $db;
    protected static $tabla = '';
    protected static $columnasDB = [];

    // Alertas y Mensajes
    protected static $alertas = [];
    
    // Definir la conexión a la BD - includes/database.php
    public static function setDB($database) {
        self::$db = $database;
    }

    public static function setAlerta($tipo, $mensaje) {
        static::$alertas[$tipo][] = $mensaje;
    }

    // Validación
    public static function getAlertas() {
        return static::$alertas;
    }

    public function validar() {
        static::$alertas = [];
        return static::$alertas;
    }

    // Consulta SQL para crear un objeto en Memoria
    public static function consultarSQL($query, $params = []) {
        // Preparar la consulta con PDO
        $stmt = self::$db->prepare($query);

        // Ejecutar la consulta con los parámetros si existen
        $stmt->execute($params);

        // Obtener los resultados como un array asociativo
        $resultado = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Iterar los resultados y convertirlos en objetos
        $array = [];
        foreach ($resultado as $registro) {
            $array[] = static::crearObjeto($registro);
        }

        // Retornar los resultados
        return $array;
    }

    // Crea el objeto en memoria que es igual al de la BD
    protected static function crearObjeto($registro) {
        $objeto = new static;

        foreach ($registro as $key => $value) {
            if (property_exists($objeto, $key)) {
                $objeto->$key = $value;
            }
        }

        return $objeto;
    }

    // Identificar y unir los atributos de la BD
    public function atributos() {
        $atributos = [];
        foreach (static::$columnasDB as $columna) {
            if ($columna === 'id') continue;
            $atributos[$columna] = $this->$columna;
        }
        return $atributos;
    }

    // Sanitizar los datos antes de guardarlos en la BD
    public function sanitizarAtributos() {
        $atributos = $this->atributos();
        $sanitizado = [];
        foreach ($atributos as $key => $value) {
            $sanitizado[$key] = htmlspecialchars($value); // Escapar para evitar ataques XSS
        }
        return $sanitizado;
    }

    // Sincroniza BD con Objetos en memoria
    public function sincronizar($args=[]) { 
        foreach($args as $key => $value) {
            if(property_exists($this, $key) && !is_null($value)) {
                $this->$key = $value;
            }
        }
    }

    // Registros - CRUD
    public function guardar() {
        if (!is_null($this->id)) {
            // Actualizar
            return $this->actualizar();
       } else {
            // Crear un nuevo registro
          return $this->crear();
        }
    }

    // Todos los registros
    public static function all() {
        $query = "SELECT * FROM " . static::$tabla;
        return self::consultarSQL($query);
    }

    // Busca un registro por su id
    public static function find($id) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE id = :id LIMIT 1";
        $params = ['id' => $id];
        $resultado = self::consultarSQL($query, $params);
        return array_shift($resultado);
    }

    public static function where($columna, $valor) {
        $query = "SELECT * FROM " . static::$tabla . " WHERE ${columna} = :valor LIMIT 1";
        $params = ['valor' => $valor];
        $resultado = self::consultarSQL($query, $params);
        return array_shift($resultado);
    }

    // Obtener registros con un límite
    public static function get($limite) {
        $query = "SELECT * FROM " . static::$tabla . " LIMIT :limite";
        $params = ['limite' => $limite];
        return self::consultarSQL($query, $params);
    }

    // Crear un nuevo registro
    public function crear() {
        $atributos = $this->sanitizarAtributos();

        // Crear la consulta
        $columnas = join(', ', array_keys($atributos));
        $valores = join(', ', array_fill(0, count($atributos), '?'));

        $query = "INSERT INTO " . static::$tabla . " (" . $columnas . ") VALUES (" . $valores . ")";

        // Preparar y ejecutar la consulta
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute(array_values($atributos));

        // Asignar el id insertado
        if ($resultado) {
            $this->id = self::$db->lastInsertId();
        }

        return $resultado;
    }

    // Actualizar el registro
    public function actualizar() {
        $atributos = $this->sanitizarAtributos();

        // Crear la consulta de actualización
        $valores = [];
        foreach ($atributos as $key => $value) {
            $valores[] = "{$key} = ?";
        }
        $query = "UPDATE " . static::$tabla . " SET " . join(', ', $valores) . " WHERE id = ? LIMIT 1";

        // Preparar y ejecutar la consulta
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute(array_merge(array_values($atributos), [$this->id]));

        return $resultado;
    }

    // Eliminar un registro por su id
    public function eliminar() {
        $query = "DELETE FROM " . static::$tabla . " WHERE id = ? LIMIT 1";

        // Preparar y ejecutar la consulta
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute([$this->id]);

        return $resultado;
    }
}
