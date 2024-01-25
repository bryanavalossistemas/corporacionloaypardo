<main class="auth">
    <h1 class="auth__heading"><?php echo $titulo; ?></h1>
    <p class="auth__texto">Es necesario confirmar tu cuenta, revisa tu bandeja de entrada para hacerlo</p>

    <a class="mensaje__enlace" href="/confirmar-cuenta?token=<?php echo $token; ?>">Confirmar Cuenta</a>
</main>