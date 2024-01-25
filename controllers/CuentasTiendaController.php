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
        if (!is_admin()) {
            header('Location: /login');
        }
        $tienda_id = $_GET['tienda_id'];
        $tienda_id = filter_var($tienda_id, FILTER_VALIDATE_INT);
        if (!$tienda_id) {
            header('Location: /admin/tiendas');
        }
        $tienda = Tienda::find($tienda_id);
        if (!$tienda) {
            header('Location: /admin/tiendas');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header("Location: /admin/tiendas/cuentas_tienda?page=1&tienda_id=$tienda_id");
        }
        $registros_por_pagina = 1;
        $total = CuentaTienda::total('tienda_id', $tienda_id);
        $paginacion = new PaginacionCuenta($pagina_actual, $registros_por_pagina, $total, 'tienda_id', $tienda_id);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header("Location: /admin/tiendas/cuentas_tienda?page=1&tienda_id=$tienda_id");
        }
        $cuentas_tienda = CuentaTienda::paginar($registros_por_pagina, $paginacion->offset(), $tienda_id);
        $router->render('admin/cuentas_tienda/index', [
            'tienda' => $tienda,
            'paginacion' => $paginacion->paginacion(),
            'cuentas_tienda' => $cuentas_tienda
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
        $cuenta_tienda = new CuentaTienda;
        $tienda_id = $_GET['tienda_id'];
        $tienda_id = filter_var($tienda_id, FILTER_VALIDATE_INT);
        if (!$tienda_id) {
            header('Location: /admin/tiendas');
        }
        $tienda = Tienda::find($tienda_id);
        if (!$tienda) {
            header('Location: /admin/tiendas');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $_POST['tienda_id'] = $tienda_id;
            $cuenta_tienda->sincronizar($_POST);
            $alertas = $cuenta_tienda->validar();
            if (empty($alertas)) {
                $resultado = $cuenta_tienda->guardar();
                if ($resultado) {
                    header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
                    return;
                }
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
        if (!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $tipos_cuenta = TipoCuenta::all();
        $bancos = Banco::all();
        $monedas = Moneda::all();
        $id = $_GET['id'];
        $tienda_id = $_GET['tienda_id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/tiendas');
        }
        if (!$tienda_id) {
            header('Location: /admin/tiendas');
        }
        $cuenta_tienda = CuentaTienda::find($id);
        $tienda = Tienda::find($tienda_id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $cuenta_tienda->sincronizar($_POST);
            $alertas = $cuenta_tienda->validar();
            if (empty($alertas)) {
                $resultado = $cuenta_tienda->guardar();
                if ($resultado) {
                    header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
                }
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $tienda_id = $_POST['tienda_id'];
            $cuenta_tienda = CuentaTienda::find($id);
            if (!isset($cuenta_tienda)) {
                header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
            }
            $resultado = $cuenta_tienda->eliminar();
            if ($resultado) {
                header("Location: /admin/tiendas/cuentas_tienda?tienda_id=$tienda_id");
            }
        }
    }
}
