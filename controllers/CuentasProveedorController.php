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
        $proveedor_id = $_GET['proveedor_id'];
        $proveedor = Proveedor::find($proveedor_id);
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header("Location: /admin/proveedores/cuentas_proveedor?page=1&proveedor_id=$proveedor_id");
        }
        $registros_por_pagina = 5;
        $total = CuentaProveedor::total('proveedor_id', $proveedor_id);
        $paginacion = new PaginacionCuenta($pagina_actual, $registros_por_pagina, $total, 'proveedor_id', $proveedor_id);
        $cuentas_proveedor = CuentaProveedor::paginar_id($registros_por_pagina, $paginacion->offset(), $proveedor_id);
        $router->render('admin/cuentas_proveedor/index', [
            'proveedor' => $proveedor,
            'paginacion' => $paginacion->paginacion(),
            'cuentas_proveedor' => $cuentas_proveedor
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $cuenta_proveedor = new CuentaProveedor;
        $proveedor_id = $_GET['proveedor_id'];
        $proveedor = Proveedor::find($proveedor_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['proveedor_id'] = $proveedor_id;
            $cuenta_proveedor->sincronizar($_POST);
            $alertas = $cuenta_proveedor->validar();
            if (empty($alertas)) {
                $cuenta_proveedor->guardar();
                header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
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
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $id = $_GET['id'];
        $proveedor_id = $_GET['proveedor_id'];
        $cuenta_proveedor = CuentaProveedor::find($id);
        $proveedor = Proveedor::find($proveedor_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cuenta_proveedor->sincronizar($_POST);
            $alertas = $cuenta_proveedor->validar();
            if (empty($alertas)) {
                $cuenta_proveedor->guardar();
                header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
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
            $id = $_POST['id'];
            $proveedor_id = $_POST['proveedor_id'];
            $cuenta_proveedor = CuentaProveedor::find($id); 
            $cuenta_proveedor->eliminar();
            header("Location: /admin/proveedores/cuentas_proveedor?proveedor_id=$proveedor_id");
    }
}
