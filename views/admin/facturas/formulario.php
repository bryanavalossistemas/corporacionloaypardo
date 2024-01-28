<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Informacion Factura</legend>
    <div class="formulario__campo formulario__campo--proforma-producto">
        <div>
            <label class="formulario__label" for="proveedor">Seleccionar Cliente</label>
            <input class="formulario__input" type="text" name="cliente_nombre" id="cliente" list="lista_clientes" value="<?php echo $factura->cliente_nombre; ?>">
            <datalist id="lista_clientes">
                <?php foreach ($clientes as $cliente) { ?>
                    <option value="<?php echo $cliente->nombre; ?>" />
                <?php } ?>
            </datalist>
        </div>
        <div>
            <label class="formulario__label" for="metodo">Metodo de Pago</label>
            <div>
                <select class="formulario__select" id="metodo" name="metodo_id">
                    <option value="">- Seleccionar -</option>
                    <?php foreach ($metodos as $metodo) { ?>
                        <option <?php echo ($pago->metodo_id === $metodo->id) ? 'selected' : '' ?> value="<?php echo $metodo->id; ?>"><?php echo $metodo->nombre; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div>
            <label class="formulario__label" for="forma">Forma de Pago</label>
            <div>
                <select class="formulario__select" id="forma" name="forma_id">
                    <option value="">- Seleccionar -</option>
                    <?php foreach ($formas as $forma) { ?>
                        <option <?php echo ($pago->forma_id === $forma->id) ? 'selected' : '' ?> value="<?php echo $forma->id; ?>"><?php echo $forma->nombre; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
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
            <input class="formulario__input" type="number" name="cantidad" id="cantidad" value="1">
        </div>
        <div>
            <label class="formulario__label" for="descuento">Descuento</label>
            <input class="formulario__input" type="number" name="descuento" id="descuento" value="0">
        </div>
    </div>
    <div class="formulario__boton-detalle-flex">
        <?php if (isset($seleccionar_producto)) { ?>
            <input class="formulario__submit formulario__submit--width-auto" type="submit" value="<?php echo $seleccionar_producto; ?>">
        <?php } else { ?>
            <a class="formulario__submit formulario__submit--width-auto" href="/admin/facturas/crear?factura_id=<?php echo $factura->id; ?>&editar=true">Actualizar Productos de la Factura</a>
        <?php  } ?>
        <div class="formulario__detalle-proforma">
            <div class="formulario__campo">
                <label class="formulario__label" for="subtotal">Subtotal</label>
                <input class="formulario__input" type="text" name="subtotal" id="subtotal" value="<?php echo $factura->subtotal; ?>">
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="igv">Igv</label>
                <input class="formulario__input" type="text" name="igv" id="igv" value="<?php echo $factura->igv; ?>">
            </div>
            <div class="formulario__campo">
                <label class="formulario__label" for="total">Total</label>
                <input class="formulario__input" type="text" name="total" id="total" value="<?php echo $factura->total; ?>">
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
            <?php foreach ($productos_facturas as $producto_factura) { ?>
                <tr class="table__tr">
                    <td class="table__td">
                        <div class="table__imagen">
                            <picture>
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_factura->producto_imagen; ?>.webp" type="image/webp">
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_factura->producto_imagen; ?>.png" type="image/png">
                                <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_factura->producto_imagen; ?>.png" alt="Imagen Producto">
                            </picture>
                        </div>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_factura->producto_nombre; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_factura->precio_unitario; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_factura->cantidad; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_factura->descuento; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_factura->importe; ?>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__formulario table__accion--eliminar" href="/admin/facturas/eliminar_producto?producto_factura_id=<?php echo $producto_factura->id; ?>">
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