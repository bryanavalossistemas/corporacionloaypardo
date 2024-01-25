<?php

namespace Controllers;

use Classes\Paginacion;
use Model\TipoCuenta;
use MVC\Router;

class TiposCuentaController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/tipos_cuenta?page=1');
        }
        $registros_por_pagina = 5;
        $total = TipoCuenta::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $tipos_cuenta = TipoCuenta::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/tipos_cuenta/index', [
            'titulo' => 'Tipos de Cuenta',
            'paginacion' => $paginacion->paginacion(),
            'tipos_cuenta' => $tipos_cuenta
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $tipo_cuenta = new TipoCuenta;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo_cuenta->sincronizar($_POST);
            $alertas = $tipo_cuenta->validar();
            if (empty($alertas)) {
                $tipo_cuenta->guardar();
                header('Location: /admin/tipos_cuenta');
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
        $alertas = [];
        $id = $_GET['id'];
        $tipo_cuenta = TipoCuenta::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tipo_cuenta->sincronizar($_POST);
            $alertas = $tipo_cuenta->validar();
            if (empty($alertas)) {
                $tipo_cuenta->guardar();
                header('Location: /admin/tipos_cuenta');
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
        $id = $_POST['id'];
        $tipo_cuenta = TipoCuenta::find($id);
        $resultado = $tipo_cuenta->eliminar();
        header('Location: /admin/tipos_cuenta');
    }
}
