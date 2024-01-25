<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/tiendas/cuentas_tienda?tienda_id=1">
        <i class="fa-solid fa-credit-card"></i>
        Mis Cuentas
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/bancos/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Banco
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($bancos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Banco</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($bancos as $banco) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $banco->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/bancos/editar?id=<?php echo $banco->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/bancos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $banco->id; ?>">
                                <button class="table__accion " type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Bancos Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>