<?php

namespace Model;
use pdo;
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
        $this->tipo_usuario = $args['tipo_usuario'] ?? 'lector';
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


    //Guardar un nuevo usuario en la base de datos
    public function guardar() {
        // Sanitizar atributos
        $atributos = $this->sanitizarAtributos();
        $this->hashPassword();

        $query = "INSERT INTO  usuarios (nombre, apellido, email, password, tipo_usuario, confirmado, token) 
        VALUES (:nombre, :apellido, :email, :password, :tipo_usuario, :confirmado, :token)";
        $stmt = self::$db->prepare($query);
        $resultado = $stmt->execute([
            'nombre' => $this->nombre,
            'apellido' => $this->apellido,
            'email' => $this->email,
            'password' => $this->password,
            'tipo_usuario' => $this->tipo_usuario,
            'confirmado' => $this->confirmado,
            'token' => $this->token
        ]);

        return $resultado;
    }
    // Hashear el password
    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // Generar un token único
    public function generarToken() {
        $this->token = bin2hex(random_bytes(16));
    }

        //iniciar sesion
    public function login() {
        //Validar entrada
        if(empty($this->email) || empty($this->password)) {
            self::$alertas['error'][] = 'Ambos campos son obligatorios';
            return false;
        }

        try {
            $query = "SELECT * FROM usuarios WHERE email = :email LIMIT 1";
            $stmt = self::$db->prepare($query);
            $stmt->execute(['email'=> $this->email]);
            $usuario = $stmt->fetch(\PDO::FETCH_ASSOC);
            
            if($usuario && password_verify($this->password, $usuario['password'])) {
                // Iniciar seisón con éxito
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                session_regenerate_id(true);

                $_SESSION['usuario'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['email'] = $usuario['email'];
                $_SESSION['login'] = true;
                $_SESSION['tipo_usuario'] = $usuario['tipo_usuario'];
                
                error_log('sesión iniciada correctamente');
                return true;
            }
            else{
                self::$alertas['error'][] = 'Usuario y/o password incorrectos';
                error_log('error al iniciar sesión: Credenciales incorrectas');
                return false;
            }
        } catch (\PDOException $e) {
            self::$alertas['error'][] = 'Usuario y/o password incorrectos';
            error_log('Error: al iniciar sesión' . $e->getMessage());
            return false;
        }    

    }
}
