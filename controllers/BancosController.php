<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Banco;
use MVC\Router;

class BancosController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/bancos?page=1');
        }
        $registros_por_pagina = 5;
        $total = Banco::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $bancos = Banco::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/bancos/index', [
            'titulo' => 'Bancos',
            'paginacion' => $paginacion->paginacion(),
            'bancos' => $bancos
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $banco = new Banco;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $banco->sincronizar($_POST);
            $alertas = $banco->validar();
            if (empty($alertas)) {
                $banco->guardar();
                header('Location: /admin/bancos');
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
        $alertas = [];
        $id = $_GET['id'];
        $banco = Banco::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $banco->sincronizar($_POST);
            $alertas = $banco->validar();
            if (empty($alertas)) {
                $banco->guardar();
                header('Location: /admin/bancos');
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
        $id = $_POST['id'];
        $banco = Banco::find($id);
        $resultado = $banco->eliminar();
        header('Location: /admin/bancos');
    }
}
