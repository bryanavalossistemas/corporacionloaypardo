<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información de la Tienda</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Tienda</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre de la Tienda" value="<?php echo $tienda->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="ruc">RUC</label>
        <input class="formulario__input" type="number" id="ruc" name="ruc" placeholder="RUC de la Tienda" value="<?php echo $tienda->ruc; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="direccion">Dirección</label>
        <input class="formulario__input" type="text" id="direccion" name="direccion" placeholder="Dirección de la Tienda" value="<?php echo $tienda->direccion; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="correo">Correo</label>
        <input class="formulario__input" type="email" id="correo" name="correo" placeholder="Correo de la Tienda" value="<?php echo $tienda->correo; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="telefono">Telefono</label>
        <input class="formulario__input" type="tel" id="telefono" name="telefono" placeholder="Telefono de la Tienda" value="<?php echo $tienda->telefono; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="celular">Celular</label>
        <input class="formulario__input" type="tel" id="celular" name="celular" placeholder="Celular de la Tienda" value="<?php echo $tienda->celular; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="imagen">Imagen/Logo Tienda</label>
        <input class="formulario__input formulario__input--file" type="file" id="imagen" name="imagen">
    </div>

    <?php if (isset($tienda->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.png" alt="Imagen Tienda">
            </picture>
        </div>
    <?php } ?>
</fieldset>