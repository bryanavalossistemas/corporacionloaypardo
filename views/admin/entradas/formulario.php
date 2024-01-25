<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Informacion Entrada</legend>
    <div class="formulario__campo">
        <label class="formulario__label" for="proveedor">Seleccionar Proveedor</label>
        <input class="formulario__input" type="text" name="proveedor_nombre" id="proveedor" list="lista_proveedores" value="<?php echo $entrada->proveedor_nombre; ?>">
        <datalist id="lista_proveedores">
            <?php foreach ($proveedores as $proveedor) { ?>
                <option value="<?php echo $proveedor->nombre; ?>" />
            <?php } ?>
        </datalist>
    </div>
    <div class="formulario__campo formulario__campo--entrada-producto">
        <div>
            <label class="formulario__label" for="proveedor">Seleccionar Producto</label>
            <input class="formulario__input" type="text" name="producto_nombre" id="producto" list="lista_productos">
            <datalist id="lista_productos">
                <?php foreach ($productos as $producto) { ?>
                    <option value="<?php echo $producto->nombre; ?>" />
                <?php } ?>
            </datalist>
        </div>
        <div>
            <label class="formulario__label" for="cantidad">Cantidad</label>
            <input class="formulario__input" type="number" name="cantidad" id="cantidad">
        </div>
    </div>
    <?php if (isset($seleccionar_producto)) { ?>
        <input class="formulario__submit formulario__submit--width-auto" type="submit" value="<?php echo $seleccionar_producto; ?>">
    <?php } else { ?>
        <a class="formulario__submit formulario__submit--width-auto" href="/admin/entradas/crear?entrada_id=<?php echo $entrada->id; ?>&editar=true">Actualizar Productos de la Entrada</a>
    <?php  } ?>
    <table class="table table--listar">
        <thead class="table__thead">
            <tr>
                <th scope="col" class="table__th">Imagen</th>
                <th scope="col" class="table__th">Producto</th>
                <th scope="col" class="table__th">Cantidad</th>
                <th scope="col" class="table__th"></th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php foreach ($productos_entradas as $producto_entrada) { ?>
                <tr class="table__tr">
                    <td class="table__td">
                        <div class="table__imagen">
                            <picture>
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_entrada->producto_imagen; ?>.webp" type="image/webp">
                                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_entrada->producto_imagen; ?>.png" type="image/png">
                                <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto_entrada->producto_imagen; ?>.png" alt="Imagen Producto">
                            </picture>
                        </div>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_entrada->producto_nombre; ?>
                    </td>
                    <td class="table__td">
                        <?php echo $producto_entrada->cantidad; ?>
                    </td>
                    <td class="table__td--acciones">
                        <a class="table__formulario table__accion--eliminar" href="/admin/entradas/eliminar_producto?producto_entrada_id=<?php echo $producto_entrada->id; ?>">
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