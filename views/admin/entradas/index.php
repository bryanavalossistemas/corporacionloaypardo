<h2 class="dashboard__heading"><?php echo $titulo; ?></h2>

<div class="dashboard__contenedor-boton">
    <div class="dashboard__contenedor-boton--end">
        <a class="dashboard__boton" href="/admin/entradas/crear_entrada_vacia">
            <i class="fa-solid fa-circle-plus"></i>
            Añadir Entrada
        </a>
    </div>
</div>

<div class="dashboard__contenedor">
    <?php if (!empty($entradas)) { ?>
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Numero</th>
                    <th scope="col" class="table__th">Fecha</th>
                    <th scope="col" class="table__th">Proveedor</th>
                    <th scope="col" class="table__th"></th>
                </tr>
            </thead>

            <tbody class="table__tbody">
                <?php foreach ($entradas as $entrada) { ?>
                    <tr class="table__tr">
                        <td class="table__td">
                            <?php echo $entrada->id; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $entrada->fecha; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $entrada->proveedor_nombre; ?>
                        </td>
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="/admin/entradas/editar?entrada_id=<?php echo $entrada->id; ?>">
                                <i class="fa-solid fa-user-pen"></i>
                                Editar
                            </a>
                            <form class="table__formulario table__accion--eliminar" method="POST" action="/admin/entradas/eliminar">
                                <input type="hidden" name="entrada_id" value="<?php echo $entrada->id; ?>">
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
        <p class="text-center">No Hay Entradas Aún</p>
    <?php } ?>
</div>

<?php echo $paginacion; ?>