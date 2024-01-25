<h2 class="dashboard__heading"><?php echo $tienda->nombre; ?> - Cuentas</h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/tipos_cuenta">
        <i class="fa-regular fa-credit-card"></i>
        Tipos de Cuenta
    </a>
    <a class="dashboard__boton-secundario" href="/admin/bancos">
        <i class="fa-regular fa-credit-card"></i>
        Bancos
    </a>
    <a class="dashboard__boton-secundario" href="/admin/monedas">
        <i class="fa-regular fa-credit-card"></i>
        Monedas
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/tiendas/cuentas_tienda/crear?tienda_id=<?php echo $tienda->id ?>">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Cuenta
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($cuentas_tienda)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Número</th>
                    <th scope="col" class="table__th">Tipo</th>
                    <th scope="col" class="table__th">Banco</th>
                    <th scope="col" class="table__th">Moneda</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($cuentas_tienda as $cuenta_tienda) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $cuenta_tienda->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cuenta_tienda->numero; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cuenta_tienda->tipo_cuenta; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cuenta_tienda->banco; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cuenta_tienda->moneda; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/tiendas/cuentas_tienda/editar?id=<?php echo $cuenta_tienda->id; ?>&tienda_id=<?php echo $tienda->id ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/tiendas/cuentas_tienda/eliminar">
                                <input type="hidden" name="id" value="<?php echo $cuenta_tienda->id; ?>">
                                <input type="hidden" name="tienda_id" value="<?php echo $tienda->id; ?>">
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
        <p class="text-center">La tienda <?php echo $tienda->nombre ?> Aún no tiene Cuentas</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>