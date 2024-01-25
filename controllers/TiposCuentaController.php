<?php

namespace Controllers;

use Classes\Paginacion;
use Model\TipoCuenta;
use MVC\Router;

class TiposCuentaController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/tipos_cuenta?page=1');
        }
        $registros_por_pagina = 5;
        $total = TipoCuenta::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/tipos_cuenta?page=1');
        }
        $tipos_cuenta = TipoCuenta::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/tipos_cuenta/index', [
            'titulo' => 'Tipos de Cuenta',
            'paginacion' => $paginacion->paginacion(),
            'tipos_cuenta' => $tipos_cuenta
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $tipo_cuenta = new TipoCuenta;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $tipo_cuenta->sincronizar($_POST);
            $alertas = $tipo_cuenta->validar();
            if (empty($alertas)) {
                $resultado = $tipo_cuenta->guardar();
                if ($resultado) {
                    header('Location: /admin/tipos_cuenta');
                    return;
                }
            }
        }
        $router->render('admin/tipos_cuenta/crear', [
            'titulo' => 'Registrar Tipo de Cuenta',
            'alertas' => $alertas,
            'tipo_cuenta' => $tipo_cuenta,
        ]);
    }

    public static function editar(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/tipos_cuenta');
        }
        $tipo_cuenta = TipoCuenta::find($id);
        if (!$tipo_cuenta) {
            header('Location: /admin/tipos_cuenta');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $tipo_cuenta->sincronizar($_POST);
            $alertas = $tipo_cuenta->validar();
            if (empty($alertas)) {
                $resultado = $tipo_cuenta->guardar();
                if ($resultado) {
                    header('Location: /admin/tipos_cuenta');
                }
            }
        }
        $router->render('admin/tipos_cuenta/editar', [
            'titulo' => 'Actualizar TipoCuenta',
            'alertas' => $alertas,
            'tipo_cuenta' => $tipo_cuenta,
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $tipo_cuenta = TipoCuenta::find($id);
            if (!isset($tipo_cuenta)) {
                header('Location: /admin/tipos_cuenta');
            }
            $resultado = $tipo_cuenta->eliminar();
            if ($resultado) {
                header('Location: /admin/tipos_cuenta');
            }
        }
    }
}
