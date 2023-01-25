<?php

if(!isset($_SESSION)){
    session_start();
}
$auth = $_SESSION['login'] ?? false;
if(!isset($inicio)){
    $inicio = false;
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="/build/css/app.css">
</head>
<body>
    <header class="header <?php echo  $inicio ? 'inicio' : '';  ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logotipo de Bienes Raices">

                </a>
                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icino menu resposive">

                </div>
                <div class="derecha">
                    <img class="dark-mode-boton" src="/build/img/dark-mode.svg">
                    <nav class="navegacion">
                        <a href="/nosotros">Nosotros</a>
                        <a href="/propiedades">Anuncios</a>
                        <a href="/blog">Blog</a>
                        <a href="/contacto">Contacto</a>
                        <?php if($auth):?>
                            <a href="/logout">Cerrar Sesion</a>
                            <?php endif ?>
                    </nav>

                </div>
                
                

            </div><!--Barra-->
            <?php if($inicio) {?>
             <h1>Ventas de Casas y Departamentos Exclusivos de Lujo</h1>
            <?php }?>
        </div>
    </header>
<?php echo $contenido; ?>
    <footer class="footer seccion">
        <div class="contenedor contenedor-footer">
            <nav class="navegacion">
                <a href="/nosotros">Nosotros</a>
                <a href="/propiedades">Anuncios</a>
                <a href="/blog">Blog</a>
                <a href="/contacto">Contacto</a>
            </nav>

        </div>
        
        <p class="copyright">Todos Los Derechos Reservador <?php echo date('Y')?> &copy;</p>

    </footer>
    <script src="/build/js/bundle.min.js"></script>
</body>
</html>