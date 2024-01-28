<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/facturas">
        <i class="fa-solid fa-file-invoice-dollar"></i>
        Facturas
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/facturas/metodos/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Método
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($metodos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Método</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($metodos as $metodo) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $metodo->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/facturas/metodos/editar?id=<?php echo $metodo->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/facturas/metodos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $metodo->id; ?>">
                                <button class="table__accion" type="submit">
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
        <p class="text-center">No Hay Metodos Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>