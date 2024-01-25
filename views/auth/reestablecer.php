<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Coloca tu nueva contraseña</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form class="formulario" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="password">Nueva contraseña</label>
            <input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Nueva contraseña">
        </div>

        <input class="formulario__submit" type="submit" value="Guardar Contraseña">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a class="acciones__enlace" href="/registro">¿Aún no tienes una cuenta? Obtener Una</a>
    </div>
</main>