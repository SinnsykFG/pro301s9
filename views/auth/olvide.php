<h1 class="nombre-pagina">Si Olvidaste tu contraseña</h1>
<p class="descripcion-pagina">Ingresa tu correo para enviarte el restablecimiento de contraseña</p>

<form class="formulario" method="POST" action="/olvide">
    <div class="campo">
        <label for="email">Email</label>
        <input
            type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
        />
    </div>

    <input type="submit" class="boton" value="Restablecer Contraseña">

    <div class="acciones">
        <a href="/login">Ya tienes una cuenta? Inicia sesión</a>
        <a href="/register">¿Aún no tienes una cuenta? Crear una</a>
</div>