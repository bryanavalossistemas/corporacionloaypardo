<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Cliente;
use Model\Producto;
use Model\Boleta;
use Model\ProductoBoleta;
use MVC\Router;

class BoletasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/boletas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Boleta::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/boletas?page=1');
        }
        $boletas = Boleta::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/boletas/index', [
            'titulo' => 'Boletas',
            'paginacion' => $paginacion->paginacion(),
            'boletas' => $boletas
        ]);
    }

    public static function crear_boleta_vacia()
    {
        $boleta = new Boleta;
        $resultado = $boleta->guardar();
        $boleta_id = $resultado['id'];
        header("Location: /admin/boletas/crear?boleta_id=$boleta_id");
    }

    public static function crear(Router $router)
    {
        $editar = $_GET['editar'] ? true : false;
        $productos = Producto::all();
        $boleta_id = $_GET['boleta_id'];
        $boleta = Boleta::buscar($boleta_id);
        $clientes = Cliente::all();
        $productos_boletas = ProductoBoleta::obtener_todos($boleta_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_nombre = $_POST['cliente_nombre'];
            $producto_nombre = $_POST['producto_nombre'];
            if ($cliente_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Cliente';
            } else {
                $cliente = Cliente::where('nombre', $cliente_nombre);
                $_POST['cliente_id'] = $cliente->id;
            }
            if ($producto_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Producto';
            } else {
                $producto_nombre = substr($producto_nombre, 0, strpos($producto_nombre, ' -'));
                $producto = Producto::where('nombre', $producto_nombre);
                $_POST['producto_id'] = $producto->id;
            }
            $boleta->sincronizar($_POST);
            if (empty($alertas)) {
                $_POST['producto_id'] = $producto->id;
                $producto_boleta = new ProductoBoleta;
                $_POST['boleta_id'] = $boleta->id;
                $precio_unitario = doubleval($producto->venta);
                $cantidad = intval($_POST['cantidad']) !== 0 ? intval($_POST['cantidad']) : 1;
                $descuento = doubleval($_POST['descuento']);
                $importe = $precio_unitario * $cantidad - $descuento;
                $_POST['precio_unitario'] = $precio_unitario;
                $_POST['importe'] = $importe;
                $producto_boleta->sincronizar($_POST);
                $producto_boleta->guardar();
                $boleta_valores = ProductoBoleta::obtener_valores($boleta_id);
                $_POST['total'] = $boleta_valores['total'];
                $_POST['igv'] = $boleta_valores['igv'];
                $_POST['subtotal'] = $boleta_valores['subtotal'];
                $boleta->sincronizar($_POST);
                $boleta->guardar();
                $producto_stock = intval($producto->stock) - $cantidad;
                $_POST['stock'] = $producto_stock;
                $producto->sincronizar($_POST);
                $producto->guardar();
                header("Location: /admin/boletas/crear?boleta_id=$boleta->id");
            }
        }
        $router->render('admin/boletas/crear', [
            'clientes' => $clientes,
            'alertas' => $alertas,
            'titulo' => "Boleta N° $boleta->id",
            'boleta' => $boleta,
            'productos_boletas' => $productos_boletas,
            'productos' => $productos,
            'seleccionar_producto' => 'Seleccionar Producto',
            'editar' => $editar
        ]);
    }

    public static function editar(Router $router)
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        $boleta_id = $_GET['boleta_id'];
        $boleta = Boleta::buscar($boleta_id);
        $productos_boletas = ProductoBoleta::obtener_todos($boleta->id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_nombre = $_POST['cliente_nombre'];
            if ($cliente_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Cliente';
            } else {
                $cliente = Cliente::where('nombre', $cliente_nombre);
                $_POST['cliente_id'] = $cliente->id;
            }
            $boleta->sincronizar($_POST);
            if (empty($alertas)) {
                $boleta->guardar();
                header("Location: /admin/boletas");
            }
        }
        $router->render('admin/boletas/editar', [
            'clientes' => $clientes,
            'alertas' => $alertas,
            'titulo' => "Actualizar Boleta N° $boleta->id",
            'boleta' => $boleta,
            'productos_boletas' => $productos_boletas,
            'productos' => $productos
        ]);
    }

    public static function eliminar_producto()
    {
        $producto_boleta_id = $_GET['producto_boleta_id'];
        $producto_boleta = ProductoBoleta::find($producto_boleta_id);
        $producto = Producto::find($producto_boleta->producto_id);
        $producto_stock = intval($producto->stock) + intval($producto_boleta->cantidad);
        $_GET['stock'] = $producto_stock;
        $producto->sincronizar($_GET);
        $producto->guardar();
        $producto_boleta->eliminar();
        $boleta = Boleta::find($producto_boleta->boleta_id);
        $boleta_valores = ProductoBoleta::obtener_valores($boleta->id);
        $_POST['total'] = $boleta_valores['total'];
        $_POST['igv'] = $boleta_valores['igv'];
        $_POST['subtotal'] = $boleta_valores['subtotal'];
        $boleta->sincronizar($_POST);
        $boleta->guardar();
        header("Location: /admin/boletas/crear?boleta_id=$producto_boleta->boleta_id");
    }

    public static function eliminar()
    {
        $boleta_id = $_POST['boleta_id'];
        $boleta = Boleta::find($boleta_id);
        $boleta->eliminar();
        header('Location: /admin/boletas');
    }
}
