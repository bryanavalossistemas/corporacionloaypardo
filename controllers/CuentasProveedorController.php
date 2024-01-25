<?php

namespace Controllers;

use Classes\PaginacionCuenta;
use Model\Banco;
use Model\CuentaProveedor;
use Model\Moneda;
use Model\Proveedor;
use Model\TipoCuenta;
use MVC\Router;

class CuentasProveedorController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $proveedor_id = $_GET['proveedor_id'];
        $proveedor_id = filter_var($proveedor_id, FILTER_VALIDATE_INT);
        if (!$proveedor_id) {
            header('Location: /admin/proveedores');
        }
        $proveedor = Proveedor::find($proveedor_id);
        if (!$proveedor) {
            header('Location: /admin/proveedores');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header("Location: /admin/proveedores/cuentas_proveedor?page=1&proveedor_id=$proveedor_id");
        }
        $registros_por_pagina = 1;
        $total = CuentaProveedor::total('proveedor_id', $proveedor_id);
        $paginacion = new PaginacionCuenta($pagina_actual, $registros_por_pagina, $total, 'proveedor_id', $proveedor_id);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header("Location: /admin/proveedores/cuentas_proveedor?page=1&proveedor_id=$proveedor_id");
        }
        $cuentas_proveedor = CuentaProveedor::paginar($registros_por_pagina, $paginacion->offset(), $proveedor_id);
        $router->render('admin/cuentas_proveedor/index', [
            'proveedor' => $proveedor,
            'paginacion' => $paginacion->paginacion(),
            'cuentas_proveedor' => $cuentas_proveedor
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $cuenta_proveedor = new CuentaProveedor;
        $proveedor_id = $_GET['proveedor_id'];
        $proveedor_id = filter_var($proveedor_id, FILTER_VALIDATE_INT);
        if (!$proveedor_id) {
            header('Location: /admin/proveedores');
        }
        $proveedor = Proveedor::find($proveedor_id);
        if (!$proveedor) {
            header('Location: /admin/proveedores');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $_POST['proveedor_id'] = $proveedor_id;
            $cuenta_proveedor->sincronizar($_POST);
            $alertas = $cuenta_proveedor->validar();
            if (empty($alertas)) {
                $resultado = $cuenta_proveedor->guardar();
                if ($resultado) {
                    header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
                    return;
                }
            }
        }
        $router->render('admin/cuentas_proveedor/crear', [
            'proveedor' => $proveedor,
            'titulo' => "$proveedor->nombre - Registrar Cuenta",
            'alertas' => $alertas,
            'cuenta_proveedor' => $cuenta_proveedor,
            'tipos_cuenta' => $tipos_cuenta,
            'bancos' => $bancos,
            'monedas' => $monedas
        ]);
    }

    public static function editar(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $id = $_GET['id'];
        $proveedor_id = $_GET['proveedor_id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/proveedores');
        }
        if (!$proveedor_id) {
            header('Location: /admin/proveedores');
        }
        $cuenta_proveedor = CuentaProveedor::find($id);
        $proveedor = Proveedor::find($proveedor_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $cuenta_proveedor->sincronizar($_POST);
            $alertas = $cuenta_proveedor->validar();
            if (empty($alertas)) {
                $resultado = $cuenta_proveedor->guardar();
                if ($resultado) {
                    header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
                }
            }
        }
        $router->render('admin/cuentas_proveedor/editar', [
            'proveedor' => $proveedor,
            'titulo' => "$proveedor->nombre - Actualizar Cuenta",
            'alertas' => $alertas,
            'cuenta_proveedor' => $cuenta_proveedor,
            'tipos_cuenta' => $tipos_cuenta,
            'bancos' => $bancos,
            'monedas' => $monedas
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $proveedor_id = $_POST['proveedor_id'];
            $cuenta_proveedor = CuentaProveedor::find($id);
            if (!isset($cuenta_proveedor)) {
                header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
            }
            $resultado = $cuenta_proveedor->eliminar();
            if ($resultado) {
                header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
            }
        }
    }
}
