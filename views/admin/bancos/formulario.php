<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información General</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Banco</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre del Banco" value="<?php echo $banco->nombre; ?>">
    </div>
</fieldset>