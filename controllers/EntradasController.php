<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Entrada;
use Model\Producto;
use Model\ProductoEntrada;
use Model\Proveedor;
use MVC\Router;

class EntradasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/entradas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Entrada::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/entradas?page=1');
        }
        $entradas = Entrada::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/entradas/index', [
            'titulo' => 'Entradas',
            'paginacion' => $paginacion->paginacion(),
            'entradas' => $entradas
        ]);
    }

    public static function crear_entrada_vacia()
    {
        $entrada = new Entrada;
        $resultado = $entrada->guardar();
        $entrada_id = $resultado['id'];
        header("Location: /admin/entradas/crear?entrada_id=$entrada_id");
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $editar = $_GET['editar'] ? true : false;
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $entrada_id = $_GET['entrada_id'];
        $entrada = Entrada::buscar($entrada_id);
        $productos_entradas = ProductoEntrada::obtener_todos($entrada_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proveedor_nombre = $_POST['proveedor_nombre'];
            $producto_nombre = $_POST['producto_nombre'];
            if ($proveedor_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Proveedor';
            } else {
                $proveedor = Proveedor::where('nombre', $proveedor_nombre);
                $_POST['proveedor_id'] = $proveedor->id;
            }
            if ($producto_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Producto';
            } else {
                $producto = Producto::where('nombre', $producto_nombre);
                $_POST['producto_id'] = $producto->id;
            }
            if ($_POST['cantidad'] === '') {
                $alertas['error'][] = 'Elija una Cantidad de Productos';
            } else {
                $cantidad = $_POST['cantidad'];
            }
            $entrada->sincronizar($_POST);
            if (empty($alertas)) {
                $_POST['entrada_id'] = $entrada->id;
                $entrada->guardar();
                $producto_entrada = new ProductoEntrada;
                $producto_entrada->sincronizar($_POST);
                $producto_entrada->guardar();
                $producto_stock = intval($producto->stock) + intval($producto_entrada->cantidad);
                $_POST['stock'] = $producto_stock;
                $producto->sincronizar($_POST);
                $producto->guardar();
                header("Location: /admin/entradas/crear?entrada_id=$entrada->id");
            }
        }
        $router->render('admin/entradas/crear', [
            'alertas' => $alertas,
            'cantidad' => $cantidad,
            'producto' => $producto,
            'titulo' => "Entrada N° $entrada->id",
            'proveedores' => $proveedores,
            'entrada' => $entrada,
            'productos_entradas' => $productos_entradas,
            'productos' => $productos,
            'seleccionar_producto' => 'Seleccionar Producto',
            'editar' => $editar
        ]);
    }

    public static function editar(Router $router)
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        $entrada_id = $_GET['entrada_id'];
        $entrada = Entrada::buscar($entrada_id);
        $productos_entradas = ProductoEntrada::obtener_todos($entrada_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proveedor_nombre = $_POST['proveedor_nombre'];
            if ($proveedor_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Proveedor';
            } else {
                $proveedor = Proveedor::where('nombre', $proveedor_nombre);
            }
            if (empty($alertas)) {
                $_POST['proveedor_id'] = $proveedor->id;
                $entrada->sincronizar($_POST);
                $entrada->guardar();
                header("Location: /admin/entradas");
            }
        }
        $router->render('admin/entradas/editar', [
            'alertas' => $alertas,
            'proveedor' => $proveedor,
            'titulo' => "Actualizar Entrada N° $entrada->id",
            'proveedores' => $proveedores,
            'entrada' => $entrada,
            'productos_entradas' => $productos_entradas,
            'productos' => $productos
        ]);
    }

    public static function eliminar_producto()
    {
        $producto_entrada_id = $_GET['producto_entrada_id'];
        $producto_entrada = ProductoEntrada::find($producto_entrada_id);
        $producto = Producto::find($producto_entrada->producto_id);
        $producto_stock = intval($producto->stock) - intval($producto_entrada->cantidad);
        $_GET['stock'] = $producto_stock;
        $producto->sincronizar($_GET);
        $producto->guardar();
        $producto_entrada->eliminar();
        header("Location: /admin/entradas/crear?entrada_id=$producto_entrada->entrada_id");
    }

    public static function eliminar()
    {
        $entrada_id = $_POST['entrada_id'];
        $entrada = Entrada::find($entrada_id);
        $resultado = $entrada->eliminar();
        header('Location: /admin/entradas');
    }
}
