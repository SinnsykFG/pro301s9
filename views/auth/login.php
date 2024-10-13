
<h1 class="nombre-pagina">Bienvenid@s a El Faro</h1>
<p class="descripcion-pagina">Informate de las últimas noticias, deportes y negocios</p>
<h3 class="nombre-pagina">Login</h3>
<p class="descripcion-pagina">Inicia sesión con tus datos para acceder</p>

<form class="formulario" method="POST" action="/login">
    <div class="campo">
        <label for="exampleFormControlInput1" class="form-label">Email:</label>
        <input 
            type="email" .
            class="form-control" 
            id="email" 
            placeholder="name@example.com"
            name="email"
            required>
    </div>
    <div class="campo">
        <label for="inputPassword6" class="col-form-label">Password</label>
        <input 
            type="password" 
            id="password" 
            class="form-control" 
            aria-describedby="passwordHelpInline" 
            name="password"
            required>
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/register">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>

