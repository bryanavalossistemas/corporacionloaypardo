<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/proveedores/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Proveedor
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($proveedores)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Imagen</th>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">RUC/DNI</th>
                    <th scope="col" class="table__th">Dirección</th>
                    <th scope="col" class="table__th">Telefono</th>
                    <th scope="col" class="table__th">Celular</th>
                    <th scope="col" class="table__th">Correo</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($proveedores as $proveedor) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <div class="table__imagen">
                                <picture>
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.png" type="image/png">
                                    <img src="<?php echo $_ENV['HOST'] . '/img/proveedores/' . $proveedor->imagen; ?>.png" alt="Imagen Proveedor">
                                </picture>
                            </div>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->documento; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->direccion; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->telefono; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->celular; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $proveedor->correo; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--cuentas" href="/admin/proveedores/cuentas_proveedor?proveedor_id=<?php echo $proveedor->id; ?>">
                                <i class="fa-regular fa-credit-card"></i>
                                Cuentas
                            </a>

                            <a class="table__accion table__accion--editar" href="/admin/proveedores/editar?id=<?php echo $proveedor->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/proveedores/eliminar">
                                <input type="hidden" name="id" value="<?php echo $proveedor->id; ?>">
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
        <p class="text-center">No Hay Proveedores Aún</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>