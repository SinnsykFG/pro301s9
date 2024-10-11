<?php

namespace Model;

class Usuario extends ActiveRecord {

    // Base de Datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email', 'tipo_usuario', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $tipo_usuario;
    public $confirmado;
    public $token;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->tipo_usuario = $args['tipo_usuario'] ?? '0';
        $this->confirmado = $args['confirmado'] ?? '0';
        $this->token = $args['token'] ?? '';
    }

    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Nombre es obligatorio';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'Apellido es obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'Email es obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Password es obligatorio';
        }

        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El password debe tener al menos 6 caracteres';
        }
        
        return self::$alertas;
    }

    // Revisar si el usuario ya existe usando PDO
    public function existeUsuario() {
        // Usamos una consulta preparada con PDO
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = :email LIMIT 1";
        
        // Preparar la consulta con PDO
        $stmt = self::$db->prepare($query);
        $stmt->bindParam(':email', $this->email, \PDO::PARAM_STR);
        $stmt->execute();

        // Obtener el resultado
        $resultado = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Si el usuario ya está registrado, mostramos una alerta
        if($resultado) {
            self::$alertas['error'][] = 'El usuario ya está registrado';
        }

        return $resultado;
    }

    // Hashear el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un token único
    public function generarToken() {
        $this->token = md5(uniqid(rand(), true));
    }
}
