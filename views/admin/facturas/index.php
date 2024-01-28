<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/facturas/metodos">
        <i class="fa-solid fa-layer-group"></i>
        Métodos de Pago
    </a>
    <a class="dashboard__boton-secundario" href="/admin/facturas/formas">
        <i class="fa-solid fa-building"></i>
        Formas de Pago
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/facturas/crear_factura_vacia">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Factura
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($facturas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Numero</th>
                    <th scope="col" class="table__th">Cliente</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Método</th>
                    <th scope="col" class="table__th">Forma</th>
                    <th scope="col" class="table__th">Total</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($facturas as $factura) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            Factura N° <?php echo $factura->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $factura->cliente_nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $factura->fecha; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $factura->metodo_nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $factura->forma_nombre; ?>
                        </td>
                        <td class="table__td">
                            S/. <?php echo $factura->total; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/facturas/editar?factura_id=<?php echo $factura->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/facturas/eliminar">
                                <input type="hidden" name="factura_id" value="<?php echo $factura->id; ?>">
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
        <p class="text-center">No Hay Facturas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>