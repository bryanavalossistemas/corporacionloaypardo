<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Recuper tu acceso a R&N</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form class="formulario" action="/olvide" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input class="formulario__input" type="email" name="email" id="email" placeholder="Tu Email">
        </div>

        <input class="formulario__submit" type="submit" value="Enviar Instrucciones">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a class="acciones__enlace" href="/registro">¿Aún no tienes una cuenta? Obtener Una</a>
    </div>
</main>