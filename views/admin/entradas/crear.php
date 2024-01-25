<h2 class="dashboard__heading">
    <?php if ($editar) { ?>
        Actualizar <?php echo $titulo; ?>
    <?php } else { ?>
        Crear <?php echo $titulo; ?>
    <?php } ?>
</h2>

<div class="dashboard__contenedor-boton dashboard__contenedor-boton--listado">
    <a class="dashboard__boton" href="/admin/entradas">
        <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="dashboard__formulario--xl">
    <?php
    include_once __DIR__ . '/../../templates/alertas.php';
    ?>
    <form class="formulario" method="POST">
        <?php include_once __DIR__ . '/formulario.php'; ?>
    </form>
    <a class="formulario__submit" href="/admin/entradas">
        <?php if ($editar) { ?>
            Actualizar Entrada
        <?php } else { ?>
            Crear Entrada
        <?php } ?>
    </a>
</div>