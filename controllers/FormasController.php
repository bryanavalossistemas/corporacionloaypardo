<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Forma;
use MVC\Router;

class FormasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/facturas/formas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Forma::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $formas = Forma::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/formas/index', [
            'titulo' => 'Formas de Pago',
            'paginacion' => $paginacion->paginacion(),
            'formas' => $formas
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $forma = new Forma;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $forma->sincronizar($_POST);
            $alertas = $forma->validar();
            if (empty($alertas)) {
                $forma->guardar();
                header('Location: /admin/facturas/formas');
            }
        }
        $router->render('admin/formas/crear', [
            'titulo' => 'Registrar Forma de Pago',
            'alertas' => $alertas,
            'forma' => $forma,
        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];
        $id = $_GET['id'];
        $forma = Forma::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $forma->sincronizar($_POST);
            $alertas = $forma->validar();
            if (empty($alertas)) {
                $forma->guardar();
                header('Location: /admin/facturas/formas');
            }
        }
        $router->render('admin/formas/editar', [
            'titulo' => 'Actualizar Forma',
            'alertas' => $alertas,
            'forma' => $forma,
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $forma = Forma::find($id);
        $forma->eliminar();
        header('Location: /admin/facturas/formas');
    }
}
