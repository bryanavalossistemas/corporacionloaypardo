<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <?php foreach ($tiendas as $tienda) { ?>
        <a class="dashboard__boton-secundario" href="/admin/tiendas/cuentas_tienda?tienda_id=<?php echo $tienda->id ?>">
            <i class="fa-regular fa-credit-card"></i>
            Mis Cuentas
        </a>
    <?php } ?>
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/tiendas/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Tienda
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($tiendas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">RUC</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Correo</th>
                    <th scope="col" class="table__th">Telefono</th>
                    <th scope="col" class="table__th">Celular</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($tiendas as $tienda) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <div class="table__imagen">
                                <picture>
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.png" type="image/png">
                                    <img src="<?php echo $_ENV['HOST'] . '/img/tiendas/' . $tienda->imagen; ?>.png" alt="Imagen Tienda">
                                </picture>
                            </div>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->ruc; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->direccion; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->correo; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->telefono; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $tienda->celular; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/tiendas/editar?id=<?php echo $tienda->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/tiendas/eliminar">
                                <input type="hidden" name="id" value="<?php echo $tienda->id; ?>">
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
        <p class="text-center">No Hay Tiendas Aún</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>