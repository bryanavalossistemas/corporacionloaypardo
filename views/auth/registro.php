<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Regístrate en R&N</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <form class="formulario" action="/registro" method="POST">
        <div class="formulario__campo">
            <label class="formulario__label" for="nombre">Nombre</label>
            <input class="formulario__input" type="text" name="nombre" id="nombre" placeholder="Tu Nombre" value="<?php echo $usuario->nombre; ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="apellido">Apellido</label>
            <input class="formulario__input" type="text" name="apellido" id="apellido" placeholder="Tu Apellido" value="<?php echo $usuario->apellido; ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="email">Email</label>
            <input class="formulario__input" type="email" name="email" id="email" placeholder="Tu Email" value="<?php echo $usuario->email; ?>">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password">Contraseña</label>
            <input class="formulario__input" type="password" name="password" id="password" placeholder="Tu Contraseña">
        </div>

        <div class="formulario__campo">
            <label class="formulario__label" for="password2">Repite tu contraseña</label>
            <input class="formulario__input" type="password" name="password2" id="password2" placeholder="Repite tu contreseña">
        </div>

        <input class="formulario__submit" type="submit" value="Crear Cuenta">
    </form>

    <div class="acciones">
        <a class="acciones__enlace" href="/login">¿Ya tienes una cuenta? Inicia Sesión</a>
        <a class="acciones__enlace" href="/olvide">¿Olvidaste tu contraseña?</a>
    </div>
</main>