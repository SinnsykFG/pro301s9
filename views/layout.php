<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>El Faro</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bungee+Tint&family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Spicy+Rice&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="\build\css\app.css">
</head>
<body>
    <header class="header">
        <div class="container-fluid text-center contenido-header">
            <div class="row">
              <div class="col-4">
                    <img class="header-logo" src="\build\img\El_faro.webp" alt="logo">
              </div>
              <div class="col">
                <h1 style="font-size: 4rem">El Faro</h1>
                <p>Noticias, deportes y negocios</p>
              </div>
              <div class="col">
                <div id="reloj"></div>
              </div>
            </div>
        </div>
    </header>
    <div class="contenedor-app">
        <div class="imagen"></div>
        <div class="app">
            <?php echo $contenido; ?>
        </div>
    </div>

    <?php
        echo $script ?? '';
    ?>
    <footer>
        <p>&copy; 2024 todos los derechos reservados</p>
    </footer>
</body>
</html>