
<h1 class="nombre-pagina">Bienvenid@s a El Faro</h1>
<p class="descripcion-pagina">Informate de las últimas noticias, deportes y negocios</p>
<h3 class="nombre-pagina">Login</h3>
<p class="descripcion-pagina">Inicia sesión con tus datos para acceder</p>

<form class="formulario" method="POST" action="/">
    <div class="campo">
        <label for="exampleFormControlInput1" class="form-label">Email address</label>
        <input 
            type="email" .
            class="form-control" 
            id="exampleFormControlInput1" 
            placeholder="name@example.com"
            name="email"/>
    </div>
    <div class="campo">
        <label for="inputPassword6" class="col-form-label">Password</label>
        <input type="password" id="inputPassword6" class="form-control" aria-describedby="passwordHelpInline" name="password">
    </div>
    <input type="submit" class="boton" value="Iniciar Sesión">
</form>

<div class="acciones">
    <a href="/register">¿Aún no tienes una cuenta? Crear una</a>
    <a href="/olvide">¿Olvidaste tu password?</a>
</div>

