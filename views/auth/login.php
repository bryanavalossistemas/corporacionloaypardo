<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Inicia Sesión en R&N</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form class="formulario" action="/login" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input class="formulario__input" type="email" name="email" id="email" placeholder="Tu Email">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Contraseña</label>
            <input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Contraseña">
        </div>

        <input class="formulario__submit" type="submit" value="Iniciar Sesión">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/registro">¿Aún no tienes una cuenta? Obtener Una</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidaste tu contraseña?</a>
    </div>
</main>