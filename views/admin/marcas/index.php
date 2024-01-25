<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/productos">
        <i class="fa-solid fa-box dashboard__icono"></i>
        Productos
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/productos/marcas/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Marca
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($marcas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Marca</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($marcas as $marca) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $marca->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/productos/marcas/editar?id=<?php echo $marca->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/productos/marcas/eliminar">
                                <input type="hidden" name="id" value="<?php echo $marca->id; ?>">
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
        <p class="text-center">No Hay Marcas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>