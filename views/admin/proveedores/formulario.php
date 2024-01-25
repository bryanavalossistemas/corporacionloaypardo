<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Proveedor</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Proveedor</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre del Proveedor" value="<?php echo $proveedor->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="documento">RUC/DNI</label>
        <input class="formulario__input" type="number" id="documento" name="documento" placeholder="RUC/DNI del Proveedor" value="<?php echo $proveedor->documento; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="direccion">Dirección</label>
        <input class="formulario__input" type="text" id="direccion" name="direccion" placeholder="Dirección del Proveedor" value="<?php echo $proveedor->direccion; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="celular">Celular</label>
        <input class="formulario__input" type="tel" id="celular" name="celular" placeholder="Celular del Proveedor" value="<?php echo $proveedor->celular; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="telefono">Telefono</label>
        <input class="formulario__input" type="tel" id="telefono" name="telefono" placeholder="Telefono del Proveedor" value="<?php echo $proveedor->telefono; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="correo">Correo</label>
        <input class="formulario__input" type="email" id="correo" name="correo" placeholder="Correo del Proveedor" value="<?php echo $proveedor->correo; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="imagen">Imagen/Logo Proveedor</label>
        <input class="formulario__input formulario__input--file" type="file" id="imagen" name="imagen">
    </div>

    <?php if (isset($proveedor->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.png" alt="Imagen Proveedor">
            </picture>
        </div>
    <?php } ?>
</fieldset>