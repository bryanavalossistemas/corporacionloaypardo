<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/proformas/crear_proforma_vacia">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Proforma
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($proformas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Numero</th>
                    <th scope="col" class="table__th">Nombre Solicitante</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Total</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($proformas as $proforma) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            Proforma N° <?php echo $proforma->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proforma->nombre_solicitante; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proforma->fecha; ?>
                        </td>
                        <td class="table__td">
                            S/. <?php echo $proforma->total; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/proformas/editar?proforma_id=<?php echo $proforma->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/proformas/eliminar">
                                <input type="hidden" name="entrada_id" value="<?php echo $proforma->id; ?>">
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
        <p class="text-center">No Hay Proformas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>