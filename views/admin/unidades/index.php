<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/productos">
        <i class="fa-solid fa-box dashboard__icono"></i>
        Productos
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/productos/unidades/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Unidad de Medida
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($unidades)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Unidad de Medida</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($unidades as $unidad) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $unidad->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/productos/unidades/editar?id=<?php echo $unidad->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/productos/unidades/eliminar">
                                <input type="hidden" name="id" value="<?php echo $unidad->id; ?>">
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
        <p class="text-center">No Hay Unidades de Medida Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>