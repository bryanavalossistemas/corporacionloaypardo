<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Informacion Proforma</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="nombre_solicitante">Nombre Solicitante</label>
        <input class="formulario__input" type="text" name="nombre_solicitante" id="nombre_solicitante" value="<?php echo $nombre_solicitante; ?>">
    </div>
    <div class="formulario__campo formulario__campo--proforma-producto">
        <div>
            <label class="formulario__label" for="proveedor">Seleccionar Producto</label>
            <input class="formulario__input" type="text" name="producto_nombre" id="producto" list="lista_productos">
            <datalist id="lista_productos">
                <?php foreach ($productos as $producto) { ?>
                    <option value="<?php echo $producto->nombre; ?> - S/. <?php echo $producto->venta; ?>" />
                <?php } ?>
            </datalist>
        </div>
        <div>
            <label class="formulario__label" for="cantidad">Cantidad</label>
            <input class="formulario__input" type="number" name="cantidad" id="cantidad">
        </div>
        <div>
            <label class="formulario__label" for="descuento">Descuento</label>
            <input class="formulario__input" type="number" name="descuento" id="descuento">
        </div>
    </div>
    <div class="formulario__boton-detalle-flex">
        <?php if (isset($seleccionar_producto)) { ?>
            <input class="formulario__submit formulario__submit--width-auto" type="submit" value="<?php echo $seleccionar_producto; ?>">
        <?php } else { ?>
            <a class="formulario__submit formulario__submit--width-auto" href="/admin/proformas/crear?proforma_id=<?php echo $proforma->id; ?>&editar=true">Actualizar Productos de la Proforma</a>
        <?php  } ?>
        <div class="formulario__detalle-proforma">
            <div class="formulario__campo">
                <label class="formulario__label" for="subtotal">Subtotal</label>
                <input class="formulario__input" type="text" name="subtotal" id="subtotal" value="<?php echo $proforma->subtotal; ?>">
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="igv">Igv</label>
                <input class="formulario__input" type="text" name="igv" id="igv" value="<?php echo $proforma->igv; ?>">
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="total">Total</label>
                <input class="formulario__input" type="text" name="total" id="total" value="<?php echo $proforma->total; ?>">
            </div>
        </div>
    </div>
    <table class="table table--listar">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Imagen</th>
                <th scope="col" class="table__th">Producto</th>
                <th scope="col" class="table__th">Precio Unitario</th>
                <th scope="col" class="table__th">Cantidad</th>
                <th scope="col" class="table__th">Descuento</th>
                <th scope="col" class="table__th">Importe</th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach ($productos_proformas as $producto_proforma) { ?>
                <tr class="table__tr">
                    <td class="table__td">
                        <div class="table__imagen">
                            <picture>
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_proforma->producto_imagen; ?>.webp" type="image/webp">
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_proforma->producto_imagen; ?>.png" type="image/png">
                                <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_proforma->producto_imagen; ?>.png" alt="Imagen Producto">
                            </picture>
                        </div>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_proforma->producto_nombre; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_proforma->precio_unitario; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_proforma->cantidad; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_proforma->descuento; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_proforma->importe; ?>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__formulario table__accion--eliminar" href="/admin/proformas/eliminar_producto?producto_proforma_id=<?php echo $producto_proforma->id; ?>">
                            <div class="table__accion">
                                <i class="fa-solid fa-circle-xmark"></i>
                                Eliminar
                            </div>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</fieldset>