<fieldset class="formulario__fieldset">
    <legend class="formulario__legend">Información General</legend>

    <div class="formulario__campo">
        <label class="formulario__label" for="nombre">Nombre Unidad de Medida</label>
        <input class="formulario__input" type="text" id="nombre" name="nombre" placeholder="Nombre de la Unidad de Medida (kilogramo, litro, caja)" value="<?php echo $unidad->nombre; ?>">
    </div>
</fieldset>