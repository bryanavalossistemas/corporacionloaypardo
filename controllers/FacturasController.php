<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Cliente;
use Model\Metodo;
use Model\Pago;
use Model\Producto;
use Model\Factura;
use Model\Forma;
use Model\ProductoFactura;
use MVC\Router;

class FacturasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/facturas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Factura::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/facturas?page=1');
        }
        $facturas = Factura::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/facturas/index', [
            'titulo' => 'Facturas',
            'paginacion' => $paginacion->paginacion(),
            'facturas' => $facturas
        ]);
    }

    public static function crear_factura_vacia()
    {
        $pago = new Pago;
        $resultado = $pago->guardar();
        $pago_id = $resultado['id'];
        $factura = new Factura;
        $factura->pago_id = $pago_id;
        $resultado = $factura->guardar();
        $factura_id = $resultado['id'];
        header("Location: /admin/facturas/crear?factura_id=$factura_id");
    }

    public static function crear(Router $router)
    {
        $editar = $_GET['editar'] ? true : false;
        $productos = Producto::all();
        $factura_id = $_GET['factura_id'];
        $factura = Factura::buscar($factura_id);
        $clientes = Cliente::all();
        $productos_facturas = ProductoFactura::obtener_todos($factura_id);
        $pago = Pago::buscar($factura->pago_id);
        $metodos = Metodo::all();
        $formas = Forma::all();
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
            if ($_POST['metodo_id'] === '') {
                $alertas['error'][] = 'Debe Elegir un Metodo de Pago';
            }
            if ($_POST['forma_id'] === '') {
                $alertas['error'][] = 'Debe Elegir una Forma de Pago';
            }
            $pago->sincronizar($_POST);
            $factura->sincronizar($_POST);
            if (empty($alertas)) {
                $_POST['producto_id'] = $producto->id;
                $producto_factura = new ProductoFactura;
                $_POST['factura_id'] = $factura->id;
                $precio_unitario = doubleval($producto->venta);
                $cantidad = intval($_POST['cantidad']) !== 0 ? intval($_POST['cantidad']) : 1;
                $descuento = doubleval($_POST['descuento']);
                $importe = $precio_unitario * $cantidad - $descuento;
                $_POST['precio_unitario'] = $precio_unitario;
                $_POST['importe'] = $importe;
                $producto_factura->sincronizar($_POST);
                $producto_factura->guardar();
                $factura_valores = ProductoFactura::obtener_valores($factura_id);
                $_POST['total'] = $factura_valores['total'];
                $_POST['igv'] = $factura_valores['igv'];
                $_POST['subtotal'] = $factura_valores['subtotal'];
                $factura->sincronizar($_POST);
                $factura->guardar();
                $producto_stock = intval($producto->stock) - $cantidad;
                $_POST['stock'] = $producto_stock;
                $producto->sincronizar($_POST);
                $producto->guardar();
                $pago->guardar();
                header("Location: /admin/facturas/crear?factura_id=$factura->id");
            }
        }
        $router->render('admin/facturas/crear', [
            'metodos' => $metodos,
            'formas' => $formas,
            'clientes' => $clientes,
            'pago' => $pago,
            'alertas' => $alertas,
            'titulo' => "Factura N° $factura->id",
            'factura' => $factura,
            'productos_facturas' => $productos_facturas,
            'productos' => $productos,
            'seleccionar_producto' => 'Seleccionar Producto',
            'editar' => $editar
        ]);
    }

    public static function editar(Router $router)
    {
        $productos = Producto::all();
        $clientes = Cliente::all();
        $factura_id = $_GET['factura_id'];
        $factura = Factura::buscar($factura_id);
        $productos_facturas = ProductoFactura::obtener_todos($factura->id);
        $pago = Pago::buscar($factura->pago_id);
        $metodos = Metodo::all();
        $formas = Forma::all();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cliente_nombre = $_POST['cliente_nombre'];
            if ($cliente_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Cliente';
            } else {
                $cliente = Cliente::where('nombre', $cliente_nombre);
                $_POST['cliente_id'] = $cliente->id;
            }
            if ($_POST['metodo_id'] === '') {
                $alertas['error'][] = 'Debe Elegir un Metodo de Pago';
            }
            if ($_POST['forma_id'] === '') {
                $alertas['error'][] = 'Debe Elegir una Forma de Pago';
            }
            $factura->sincronizar($_POST);
            $pago->sincronizar($_POST);
            if (empty($alertas)) {
                $pago->guardar();
                $factura->guardar();
                header("Location: /admin/facturas");
            }
        }
        $router->render('admin/facturas/editar', [
            'metodos' => $metodos,
            'formas' => $formas,
            'clientes' => $clientes,
            'pago' => $pago,
            'alertas' => $alertas,
            'titulo' => "Actualizar Factura N° $factura->id",
            'factura' => $factura,
            'productos_facturas' => $productos_facturas,
            'productos' => $productos
        ]);
    }

    public static function eliminar_producto()
    {
        $producto_factura_id = $_GET['producto_factura_id'];
        $producto_factura = ProductoFactura::find($producto_factura_id);
        $producto = Producto::find($producto_factura->producto_id);
        $producto_stock = intval($producto->stock) + intval($producto_factura->cantidad);
        $_GET['stock'] = $producto_stock;
        $producto->sincronizar($_GET);
        $producto->guardar();
        $producto_factura->eliminar();
        $factura = Factura::find($producto_factura->factura_id);
        $factura_valores = ProductoFactura::obtener_valores($factura->id);
        $_POST['total'] = $factura_valores['total'];
        $_POST['igv'] = $factura_valores['igv'];
        $_POST['subtotal'] = $factura_valores['subtotal'];
        $factura->sincronizar($_POST);
        $factura->guardar();
        header("Location: /admin/facturas/crear?factura_id=$producto_factura->factura_id");
    }

    public static function eliminar()
    {
        $factura_id = $_POST['factura_id'];
        $factura = Factura::find($factura_id);
        $factura->eliminar();
        header('Location: /admin/facturas');
    }
}
