<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/tiendas/cuentas_tienda?tienda_id=1">
        <i class="fa-solid fa-credit-card"></i>
        Mis Cuentas
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/tipos_cuenta/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Tipo de Cuenta
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($tipos_cuenta)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Tipo de Cuenta</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($tipos_cuenta as $tipo_cuenta) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $tipo_cuenta->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/tipos_cuenta/editar?id=<?php echo $tipo_cuenta->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/tipos_cuenta/eliminar">
                                <input type="hidden" name="id" value="<?php echo $tipo_cuenta->id; ?>">
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
        <p class="text-center">No Hay Tipos de Cuenta Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>