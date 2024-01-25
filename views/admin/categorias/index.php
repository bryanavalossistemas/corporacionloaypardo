<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/productos">
        <i class="fa-solid fa-box dashboard__icono"></i>
        Productos
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/productos/categorias/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Categoría
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($categorias)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($categorias as $categoria) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $categoria->nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/productos/categorias/editar?id=<?php echo $categoria->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/productos/categorias/eliminar">
                                <input type="hidden" name="id" value="<?php echo $categoria->id; ?>">
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
        <p class="text-center">No Hay Categorías Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>