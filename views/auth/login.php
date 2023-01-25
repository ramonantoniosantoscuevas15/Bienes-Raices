<main class="contenedor seccion contenido-centrado">
        <h1>Inicial Sesion</h1>
        <?php foreach($errores as $erorr):?>
            <div class="alerta error">
                <?php echo $erorr?>

            </div>
        <?php endforeach ?>
        <form class="formulario" method="POST" novalidate action="/login">
            <fieldset>
                <legend>Email y Password</legend>
                
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="Tu Email" id="email" required>
                <label for="password">Password</label>
                <input type="password" name="password" placeholder="Tu Password" id="password" required>
                
            </fieldset>
            <input type="submit" value="Iniciar Sesion" class="boton boton-verde">

        </form>

    </main>