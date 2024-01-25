<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <a class="dashboard__boton-secundario" href="/admin/productos/categorias">
        <i class="fa-solid fa-layer-group"></i>
        Categorías
    </a>
    <a class="dashboard__boton-secundario" href="/admin/productos/marcas">
        <i class="fa-solid fa-building"></i>
        Marcas
    </a>
    <a class="dashboard__boton-secundario" href="/admin/productos/unidades">
        <i class="fa-brands fa-unity"></i>
        Unidades
    </a>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/productos/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Producto
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($productos)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">Producto</th>
                    <th scope="col" class="table__th">Costo</th>
                    <th scope="col" class="table__th">Venta</th>
                    <th scope="col" class="table__th">Stock</th>
                    <th scope="col" class="table__th">Categoría</th>
                    <th scope="col" class="table__th">Marca</th>
                    <th scope="col" class="table__th">Unidad</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($productos as $producto) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <div class="table__imagen">
                                <picture>
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" type="image/png">
                                    <img src="<?php echo $_ENV['HOST'] . '/img/productos/' . $producto->imagen; ?>.png" alt="Imagen Producto">
                                </picture>
                            </div>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->costo; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->venta; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->stock; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->categoria_nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->marca_nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $producto->unidad_nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/productos/editar?id=<?php echo $producto->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/productos/eliminar">
                                <input type="hidden" name="id" value="<?php echo $producto->id; ?>">
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
        <p class="text-center">No Hay Productos Aún</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>