
<h3 class="nombre-pagina">Crear Cuenta</h3>
<p class="descripcion-pagina">Llena el siguiente formulario para creat tu cuenta</p>
<?php  
  include_once __DIR__ . "/../templates/alertas.php";
?>
  <form class="formulario" method="POST" action="/register" >
      <input type="hidden" name="action" value="register">
      <div class="campo">
        <label for="nombre">Nombre: </label>
        <input 
            type="text" 
            id="nombre" 
            name="nombre" 
            placeholder="Tu nombre"
            value="<?php echo s($usuario->nombre); ?>"
            required
        />
      </div>
      <div class="campo">
        <label for="apellido">Apellido: </label>
        <input type="text" id="apellido" name="apellido" placeholder="Tu apellido" required>
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
        <label for="role">Rol del usuario:</label>
        <select id="role" name="role">
          <option value="lector">Lector</option>
          <option value="editor">Editor</option>
        </select>
      </div>
                
      <button class= boto type="submit">Crear Cuenta</button>
</form>
              
<div class="acciones">
    <a href="/login">¿Ya tienes una cuenta? Inicia sesión</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>