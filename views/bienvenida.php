<html>
<head>
    <meta charset="UTF-8">
    <title>Inicio</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Tint&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../build/css/app.css">
</head>
<body onload="actReloj(), cargarNoticias()">
    <header class="header">
        <div class="container-fluid text-center contenido-header">
            <div class="row">
              <div class="col-4">
                     <img class="header-logo" src="../src/img/El_faro.webp" alt="logo">
              </div>
              <div class="col">
                <h1>El Faro</h1>
                <p>Noticias, deportes y negocios</p>
              </div>
              <div class="col">
                <div id="reloj"></div>
              </div>
            </div>
        </div>
    </header>
    <div class="nav-bg">
        <nav class="navbar navbar-expand-lg bg-body-tertiary navbar" style="font-size: 2.8rem;">
            <div class="container-fluid">
                <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                    <div class="navbar-nav">
                        <a class="nav-link active" aria-current="page" href="../bienvenida.php">Inicio</a>
                        <a class="nav-link" href="./views/register.php">Registrarse</a>
                        <a class="nav-link" href="/views/auth/login.php">Login</a>
                    </div>
                </div>
            </div>
        </nav>
    </div>
    <main>

    </main>
</html>