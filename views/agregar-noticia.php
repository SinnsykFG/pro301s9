
    <div class="nav-bg">
    <nav class="navbar navbar-expand-lg bg-body-tertiary navbar" style="font-size: 2.8rem;">
        <div class="container-fluid">
          <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
            <div class="navbar-nav">
              <a class="nav-link active" aria-current="page" href="../bienvenida.php">Inicio</a>
              <a class="nav-link" href="./views/noticias.php">Noticias</a>
              <a class="nav-link" href="./views/deportes.php">Deportes</a>
              <a class="nav-link" href="./views/negocios.php">Negocios</a>
              <a class="nav-link" href="./views/contacto.php">Contacto</a>
            </div>
          </div>
        </div>
      </nav>
</div>
    <main>
      <div class= "container-fluid text-center">
        <div class="mb-3">
          <form action="index.php" method="POST" id="form-noticia" class="formulario bg-dark text-white p-4 rounded">
            <input type="hidden" name="action" value="create_article">
            <div class = "row">
            <label for="title">Título:</label>
            <input type="text" name="title" id="title">
            </div>
            <div class="row">
            <label for="content">Contenido:</label>
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
            </div>
            <div class="row">
            <button type="submit">Crear Artículo</button>
            </div>
          </form>
        </div>
      </div>
      </main>
