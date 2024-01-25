<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Banco;
use MVC\Router;

class BancosController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/bancos?page=1');
        }
        $registros_por_pagina = 5;
        $total = Banco::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/bancos?page=1');
        }
        $bancos = Banco::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/bancos/index', [
            'titulo' => 'Bancos',
            'paginacion' => $paginacion->paginacion(),
            'bancos' => $bancos
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $banco = new Banco;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $banco->sincronizar($_POST);
            $alertas = $banco->validar();
            if (empty($alertas)) {
                $resultado = $banco->guardar();
                if ($resultado) {
                    header('Location: /admin/bancos');
                    return;
                }
            }
        }
        $router->render('admin/bancos/crear', [
            'titulo' => 'Registrar Banco',
            'alertas' => $alertas,
            'banco' => $banco,
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
            header('Location: /admin/bancos');
        }
        $banco = Banco::find($id);
        if (!$banco) {
            header('Location: /admin/bancos');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $banco->sincronizar($_POST);
            $alertas = $banco->validar();
            if (empty($alertas)) {
                $resultado = $banco->guardar();
                if ($resultado) {
                    header('Location: /admin/bancos');
                }
            }
        }
        $router->render('admin/bancos/editar', [
            'titulo' => 'Actualizar Banco',
            'alertas' => $alertas,
            'banco' => $banco,
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $banco = Banco::find($id);
            if (!isset($banco)) {
                header('Location: /admin/bancos');
            }
            $resultado = $banco->eliminar();
            if ($resultado) {
                header('Location: /admin/bancos');
            }
        }
    }
}
