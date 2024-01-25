<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Unidad;
use MVC\Router;

class UnidadesController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/productos/unidades?page=1');
        }
        $registros_por_pagina = 5;
        $total = Unidad::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $unidades = Unidad::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/unidades/index', [
            'titulo' => 'Unidades de Medida',
            'paginacion' => $paginacion->paginacion(),
            'unidades' => $unidades
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $unidad = new Unidad;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $unidad->sincronizar($_POST);
            $alertas = $unidad->validar();
            if (empty($alertas)) {
                $unidad->guardar();
                header('Location: /admin/productos/unidades');
            }
        }
        $router->render('admin/unidades/crear', [
            'titulo' => 'Registrar Unidad de Medida',
            'alertas' => $alertas,
            'unidad' => $unidad,
        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];
        $id = $_GET['id'];
        $unidad = Unidad::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $unidad->sincronizar($_POST);
            $alertas = $unidad->validar();
            if (empty($alertas)) {
                $unidad->guardar();
                header('Location: /admin/productos/unidades');
            }
        }
        $router->render('admin/unidades/editar', [
            'titulo' => 'Actualizar Unidad de Medida',
            'alertas' => $alertas,
            'unidad' => $unidad,
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $unidad = Unidad::find($id);
        $unidad->eliminar();
        header('Location: /admin/productos/unidades');
    }
}
