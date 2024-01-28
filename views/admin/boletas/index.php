<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/boletas/crear_boleta_vacia">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Boleta
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($boletas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Numero</th>
                    <th scope="col" class="table__th">Cliente</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Total</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($boletas as $boleta) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            Boleta N° <?php echo $boleta->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $boleta->cliente_nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $boleta->fecha; ?>
                        </td>
                        <td class="table__td">
                            S/. <?php echo $boleta->total; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/boletas/editar?boleta_id=<?php echo $boleta->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/boletas/eliminar">
                                <input type="hidden" name="boleta_id" value="<?php echo $boleta->id; ?>">
                                <button class="table__accion " type="submit">
                                    <i class="fa-solid fa-circle-xmark"></i>
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    <?php } else { ?>
        <p class="text-center">No Hay Boletas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>