<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/tiendas/cuentas_tienda?tienda_id=1">
        <i class="fa-solid fa-credit-card"></i>
        Mis Cuentas
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/monedas/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Moneda
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($monedas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Moneda</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($monedas as $moneda) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $moneda->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/monedas/editar?id=<?php echo $moneda->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/monedas/eliminar">
                                <input type="hidden" name="id" value="<?php echo $moneda->id; ?>">
                                <button class="table__accion" type="submit">
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
        <p class="text-center">No Hay Monedas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>