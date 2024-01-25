<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/clientes/crear">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Cliente
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($clientes)) { ?>
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
                <?php foreach ($clientes as $cliente) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <div class="table__imagen">
                                <picture>
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.webp" type="image/webp">
                                    <source srcset="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.png" type="image/png">
                                    <img src="<?php echo $_ENV['HOST'] . '/img/clientes/' . $cliente->imagen; ?>.png" alt="Imagen Cliente">
                                </picture>
                            </div>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->nombre; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->documento; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->direccion; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->telefono; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->celular; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $cliente->correo; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/clientes/editar?id=<?php echo $cliente->id; ?>">
                                <i class="fa-solid fa-pencil"></i>
                                Editar
                            </a>

                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/clientes/eliminar">
                                <input type="hidden" name="id" value="<?php echo $cliente->id; ?>">
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
        <p class="text-center">No Hay Clientes Aún</p>
    <?php } ?>
</div>

<?php
echo $paginacion;
?>