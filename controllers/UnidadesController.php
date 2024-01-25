<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Unidad;
use MVC\Router;

class UnidadesController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/productos/unidades?page=1');
        }
        $registros_por_pagina = 5;
        $total = Unidad::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/productos/unidades?page=1');
        }
        $unidades = Unidad::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/unidades/index', [
            'titulo' => 'Unidades de Medida',
            'paginacion' => $paginacion->paginacion(),
            'unidades' => $unidades
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $unidad = new Unidad;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $unidad->sincronizar($_POST);
            $alertas = $unidad->validar();
            if (empty($alertas)) {
                $resultado = $unidad->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/unidades');
                    return;
                }
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
        if (!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/productos/unidades');
        }
        $unidad = Unidad::find($id);
        if (!$unidad) {
            header('Location: /admin/productos/unidades');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $unidad->sincronizar($_POST);
            $alertas = $unidad->validar();
            if (empty($alertas)) {
                $resultado = $unidad->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/unidades');
                }
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $unidad = Unidad::find($id);
            if (!isset($unidad)) {
                header('Location: /admin/productos/unidades');
            }
            $resultado = $unidad->eliminar();
            if ($resultado) {
                header('Location: /admin/productos/unidades');
            }
        }
    }
}
