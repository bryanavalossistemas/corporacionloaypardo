<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información del Cliente</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Cliente</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre del Cliente" value="<?php echo $cliente->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="documento">RUC/DNI</label>
        <input class="formulario__input" type="number" id="documento" name="documento" placeholder="RUC/DNI del Cliente" value="<?php echo $cliente->documento; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="direccion">Dirección</label>
        <input class="formulario__input" type="text" id="direccion" name="direccion" placeholder="Dirección del Cliente" value="<?php echo $cliente->direccion; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="celular">Celular</label>
        <input class="formulario__input" type="tel" id="celular" name="celular" placeholder="Celular del Cliente" value="<?php echo $cliente->celular; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="telefono">Telefono</label>
        <input class="formulario__input" type="tel" id="telefono" name="telefono" placeholder="Telefono del Cliente" value="<?php echo $cliente->telefono; ?>">
    </div>
    
    <div class="formulario__campo">
        <label class="formulario__label" for="correo">Correo</label>
        <input class="formulario__input" type="email" id="correo" name="correo" placeholder="Correo del Cliente" value="<?php echo $cliente->correo; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="imagen">Imagen/Logo Cliente</label>
        <input class="formulario__input formulario__input--file" type="file" id="imagen" name="imagen">
    </div>

    <?php if (isset($cliente->imagen_actual)) { ?>
        <p class="formulario__texto">Imagen Actual:</p>
        <div class="formulario__imagen">
            <picture>
                <source srcset="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.webp" type="image/webp">
                <source srcset="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.png" type="image/png">
                <img src="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.png" alt="Imagen Cliente">
            </picture>
        </div>
    <?php } ?>
</fieldset>