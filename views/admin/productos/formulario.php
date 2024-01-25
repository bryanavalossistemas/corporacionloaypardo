<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Producto</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Producto</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre del Producto" value="<?php echo $producto->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="venta">Precio Venta Producto</label>
        <input class="formulario__input" type="number" step=".01" id="venta" name="venta" placeholder="Precio Venta del Producto" value="<?php echo $producto->venta; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="costo">Precio Costo Producto</label>
        <input class="formulario__input" type="number" step=".01" id="costo" name="costo" placeholder="Precio Costo del Producto" value="<?php echo $producto->costo; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="stock">Stock Producto</label>
        <input class="formulario__input" type="number" id="stock" name="stock" placeholder="Stock del Producto" value="<?php echo $producto->stock; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Categoría del Producto</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="categoria" name="categoria_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($categorias as $categoria) { ?>
                    <option <?php echo ($producto->categoria_id === $categoria->id) ? 'selected' : '' ?> value="<?php echo $categoria->id; ?>"><?php echo $categoria->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/categorias/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Añadir Categoría
            </a>
        </div>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="marca">Marca del Producto</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="marca" name="marca_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($marcas as $marca) { ?>
                    <option <?php echo ($producto->marca_id === $marca->id) ? 'selected' : '' ?> value="<?php echo $marca->id; ?>"><?php echo $marca->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/marcas/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Añadir Marca
            </a>
        </div>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="categoria">Unidad de medida del Producto</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="unidad" name="unidad_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($unidades as $unidad) { ?>
                    <option <?php echo ($producto->unidad_id === $unidad->id) ? 'selected' : '' ?> value="<?php echo $unidad->id; ?>"><?php echo $unidad->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/unidades/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Añadir Unidad
            </a>
        </div>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="imagen">Imagen Producto</label>
        <input class="formulario__input formulario__input--file" type="file" id="imagen" name="imagen">
    </div>

    <?php if (isset($producto->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" alt="Imagen Producto">
            </picture>
        </div>
    <?php } ?>
</fieldset>