<?php

// Incluir la conexión a la base de datos
require_once "..\includes\pdo.php";
require_once __DIR__ . '/../templates/alertas.php';
use Model\Usuario;


//    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Variables desde el formulario
//        $username = $_POST['username']; 
//        $email = $_POST['email'];
//        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
//        $role = 'lector'; // Asignamos rol por defecto
//    }

// Verificar si el formulario ha sido enviado
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && $_POST['action'] == 'register') {
        // Recoger los datos del formulario
        $nombre = $_POST['nombre'];
        $apellido = $_POST['apellido'];
        $email = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $tipo_usuario = $_POST['tipo_usuario'];  // Recibir el rol del formulario

        // Validar si el correo ya está registrado
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $email]);
        
        if ($stmt->rowCount() > 0) {
            // Si ya existe un usuario con ese correo
            echo "Este correo ya está registrado. <a href='/login'>Inicia sesión aquí</a>";
        } else {
            // Insertar nuevo usuario en la base de datos
            $sql = "INSERT INTO usuarios (username, email, password, tipo_usuario) VALUES (:username, :email, :password, :tipo_usuario)";
            $stmt = $db->prepare($sql);
            
            $fullName = $nombre . ' ' . $apellido;  // Combinar nombre y apellido
            if ($stmt->execute(['username' => $fullName, 'email' => $email, 'password' => $password, 'tipo_usuario' => $tipo_usuario])) {
                echo "Registro exitoso. <a href='/login'>Inicia sesión aquí</a>";
            } else {
                echo "Error en el registro.";
            }
        }
    }
?>
<h3 class="nombre-pagina">Crear Cuenta</h3>
<p class="descripcion-pagina">Llena el siguiente formulario para creat tu cuenta</p>
<form class="formulario" method="POST" action="/register">
    <input type="hidden" name="action" value="register">
    <div class="campo">
        <label for="nombre">Nombre: </label>
        <input 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Tu nombre"
            required>
    </div>
    <div class="campo">
        <label for="apellido">Apellido: </label>
        <input 
            type="text" 
            id="apellido" 
            name="apellido" 
            placeholder="Tu apellido" 
            required>
    </div>
    <div class="campo">
        <label for="email">Correo Electrónico: </label>
        <input type="email" id="email" name="email" required>
    </div>
    <div class="campo">
        <label for="password">Contraseña: </label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <!-- Selección del rol del usuario -->
    <div class="campo">
        <label for="tipo_usuario">Rol del usuario:</label>
        <select id="tipo_usuario" name="tipo_usuario">
            <option value="lector">lector</option>
            <option value="editor">editor</option>
        </select>
    </div>
    
    <button class="boton" type="submit">Crear Cuenta</button>
</form>
              
<div class="acciones">
    <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>