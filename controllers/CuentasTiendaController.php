<?php

namespace Controllers;

use Classes\PaginacionCuenta;
use Model\Banco;
use Model\CuentaTienda;
use Model\Moneda;
use Model\Tienda;
use Model\TipoCuenta;
use MVC\Router;

class CuentasTiendaController
{
    public static function index(Router $router)
    {
        $tienda_id = $_GET['tienda_id'];
        $tienda = Tienda::find($tienda_id);
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual) {
            header("Location: /admin/tiendas/cuentas_tienda?page=1&tienda_id=$tienda_id");
        }
        $registros_por_pagina = 5;
        $total = CuentaTienda::total('tienda_id', $tienda_id);
        $paginacion = new PaginacionCuenta($pagina_actual, $registros_por_pagina, $total, 'tienda_id', $tienda_id);
        $cuentas_tienda = CuentaTienda::paginar_id($registros_por_pagina, $paginacion->offset(), $tienda_id);
        $router->render('admin/cuentas_tienda/index', [
            'tienda' => $tienda,
            'paginacion' => $paginacion->paginacion(),
            'cuentas_tienda' => $cuentas_tienda
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $cuenta_tienda = new CuentaTienda;
        $tienda_id = $_GET['tienda_id'];
        $tienda = Tienda::find($tienda_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_POST['tienda_id'] = $tienda_id;
            $cuenta_tienda->sincronizar($_POST);
            $alertas = $cuenta_tienda->validar();
            if (empty($alertas)) {
                $cuenta_tienda->guardar();
                header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
            }
        }
        $router->render('admin/cuentas_tienda/crear', [
            'tienda' => $tienda,
            'titulo' => "$tienda->nombre - Registrar Cuenta",
            'alertas' => $alertas,
            'cuenta_tienda' => $cuenta_tienda,
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
        $tienda_id = $_GET['tienda_id'];
        $cuenta_tienda = CuentaTienda::find($id);
        $tienda = Tienda::find($tienda_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $cuenta_tienda->sincronizar($_POST);
            $alertas = $cuenta_tienda->validar();
            if (empty($alertas)) {
                $cuenta_tienda->guardar();
                header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
            }
        }
        $router->render('admin/cuentas_tienda/editar', [
            'tienda' => $tienda,
            'titulo' => "$tienda->nombre - Actualizar Cuenta",
            'alertas' => $alertas,
            'cuenta_tienda' => $cuenta_tienda,
            'tipos_cuenta' => $tipos_cuenta,
            'bancos' => $bancos,
            'monedas' => $monedas
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $tienda_id = $_POST['tienda_id'];
        $cuenta_tienda = CuentaTienda::find($id);
        $resultado = $cuenta_tienda->eliminar();
        header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
    }
}
