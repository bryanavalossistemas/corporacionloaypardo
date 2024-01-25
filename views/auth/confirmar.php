<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Tu cuenta en R&N</p>

    <?php require_once __DIR__ . '/../templates/alertas.php' ?>

    <div class="acciones">
        <a class="acciones__enlace acciones__enlace--centrar" href="/login">Iniciar Sesión</a>
    </div>
</main>