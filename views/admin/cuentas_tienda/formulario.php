<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información Cuenta</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Cuenta</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre de la Cuenta" value="<?php echo $cuenta_tienda->nombre; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="numero">Numero Cuenta</label>
        <input class="formulario__input" type="number" id="numero" name="numero" placeholder="Numero de la Cuenta" value="<?php echo $cuenta_tienda->numero; ?>">
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="tipo_cuenta">Tipo de Cuenta</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="tipo_cuenta" name="tipo_cuenta_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($tipos_cuenta as $tipo_cuenta) { ?>
                    <option <?php echo ($cuenta_tienda->tipo_cuenta_id === $tipo_cuenta->id) ? 'selected' : '' ?> value="<?php echo $tipo_cuenta->id; ?>"><?php echo $tipo_cuenta->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/tipos_cuenta/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Tipo Cuenta
            </a>
        </div>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="tipo_cuenta">Banco de la Cuenta</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="banco" name="banco_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($bancos as $banco) { ?>
                    <option <?php echo ($cuenta_tienda->banco_id === $banco->id) ? 'selected' : '' ?> value="<?php echo $banco->id; ?>"><?php echo $banco->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/bancos/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Añadir Banco
            </a>
        </div>
    </div>

    <div class="formulario__campo">
        <label class="formulario__label" for="tipo_cuenta">Moneda de la Cuenta</label>
        <div class="formulario__campo--row">
            <select class="formulario__select" id="moneda" name="moneda_id">
                <option value="">- Seleccionar -</option>
                <?php foreach ($monedas as $moneda) { ?>
                    <option <?php echo ($cuenta_tienda->moneda_id === $moneda->id) ? 'selected' : '' ?> value="<?php echo $moneda->id; ?>"><?php echo $moneda->nombre; ?></option>
                <?php } ?>
            </select>
            <a class="dashboard__boton" href="/admin/monedas/crear" target="_blank">
                <i class="fa-solid fa-circle-plus"></i>
                Añadir Moneda
            </a>
        </div>
    </div>
</fieldset>