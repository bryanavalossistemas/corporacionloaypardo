<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Factura;
use Model\Producto;
use Model\ProductoProforma;
use Model\Proforma;
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
        $total = Proforma::total();
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

    public static function crear_proforma_vacia()
    {
        $proforma = new Proforma;
        $resultado = $proforma->guardar();
        $proforma_id = $resultado['id'];
        header("Location: /admin/facturas/crear?proforma_id=$proforma_id");
    }

    public static function crear(Router $router)
    {
        $editar = $_GET['editar'] ? true : false;
        $productos = Producto::all();
        $proforma_id = $_GET['proforma_id'];
        $proforma = Proforma::buscar($proforma_id);
        $productos_proformas = ProductoProforma::obtener_todos($proforma_id);
        $nombre_solicitante = 'varios';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['nombre_solicitante'] === '') {
                $alertas['error'][] = 'Nombre de Solicitante Vacio';
            } else {
                $nombre_solicitante = $_POST['nombre_solicitante'];
            }
            $producto_nombre = $_POST['producto_nombre'];
            if ($producto_nombre === '') {
                $alertas['error'][] = 'Debe Elegir un Producto';
            } else {
                $producto_nombre = substr($producto_nombre, 0, strpos($producto_nombre, ' -'));
                $producto = Producto::where('nombre', $producto_nombre);
                $_POST['producto_id'] = $producto->id;
            }
            if (empty($alertas)) {
                $_POST['producto_id'] = $producto->id;
                $producto_proforma = new ProductoProforma;
                $_POST['proforma_id'] = $proforma->id;
                $precio_unitario = doubleval($producto->venta);
                $cantidad = intval($_POST['cantidad']) !== 0 ? intval($_POST['cantidad']) : 1;
                $descuento = doubleval($_POST['descuento']);
                $importe = $precio_unitario * $cantidad - $descuento;
                $_POST['precio_unitario'] = $precio_unitario;
                $_POST['importe'] = $importe;
                $producto_proforma->sincronizar($_POST);
                $producto_proforma->guardar();
                $proforma_valores = ProductoProforma::obtener_valores($proforma_id);
                $_POST['total'] = $proforma_valores['total'];
                $_POST['igv'] = $proforma_valores['igv'];
                $_POST['subtotal'] = $proforma_valores['subtotal'];
                $proforma->sincronizar($_POST);
                $proforma->guardar();
                $producto_stock = intval($producto->stock) - $cantidad;
                $_POST['stock'] = $producto_stock;
                $producto->sincronizar($_POST);
                $producto->guardar();
                header("Location: /admin/facturas/crear?proforma_id=$proforma->id");
            }
        }
        $router->render('admin/facturas/crear', [
            'alertas' => $alertas,
            'nombre_solicitante' => $nombre_solicitante,
            'titulo' => "Proforma N° $proforma->id",
            'proforma' => $proforma,
            'productos_proformas' => $productos_proformas,
            'productos' => $productos,
            'seleccionar_producto' => 'Seleccionar Producto',
            'editar' => $editar
        ]);
    }

    public static function editar(Router $router)
    {
        $productos = Producto::all();
        $proforma_id = $_GET['proforma_id'];
        $proforma = Proforma::buscar($proforma_id);
        $productos_proformas = ProductoProforma::obtener_todos($proforma->id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $proforma->sincronizar($_POST);
            $proforma->guardar();
            header("Location: /admin/facturas");
        }
        $router->render('admin/facturas/editar', [
            'alertas' => $alertas,
            'nombre_solicitante' => $proforma->nombre_solicitante,
            'titulo' => "Actualizar Proforma N° $proforma->id",
            'proforma' => $proforma,
            'productos_proformas' => $productos_proformas,
            'productos' => $productos
        ]);
    }

    public static function eliminar_producto()
    {
        $producto_proforma_id = $_GET['producto_proforma_id'];
        $producto_proforma = ProductoProforma::find($producto_proforma_id);
        $producto = Producto::find($producto_proforma->producto_id);
        $producto_stock = intval($producto->stock) + intval($producto_proforma->cantidad);
        $_GET['stock'] = $producto_stock;
        $producto->sincronizar($_GET);
        $producto->guardar();
        $producto_proforma->eliminar();
        $proforma = Proforma::find($producto_proforma->proforma_id);
        $proforma_valores = ProductoProforma::obtener_valores($proforma->id);
        $_POST['total'] = $proforma_valores['total'];
        $_POST['igv'] = $proforma_valores['igv'];
        $_POST['subtotal'] = $proforma_valores['subtotal'];
        $proforma->sincronizar($_POST);
        $proforma->guardar();
        header("Location: /admin/facturas/crear?proforma_id=$producto_proforma->proforma_id");
    }

    public static function eliminar()
    {
        $proforma_id = $_POST['proforma_id'];
        $proforma = Proforma::find($proforma_id);
        $proforma->eliminar();
        header('Location: /admin/facturas');
    }
}
