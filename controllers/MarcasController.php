<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Marca;
use MVC\Router;

class MarcasController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/productos/marcas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Marca::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/productos/marcas?page=1');
        }
        $marcas = Marca::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/marcas/index', [
            'titulo' => 'Marcas',
            'paginacion' => $paginacion->paginacion(),
            'marcas' => $marcas
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $marca = new Marca;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $marca->sincronizar($_POST);
            $alertas = $marca->validar();
            if (empty($alertas)) {
                $resultado = $marca->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/marcas');
                    return;
                }
            }
        }
        $router->render('admin/marcas/crear', [
            'titulo' => 'Registrar Marca',
            'alertas' => $alertas,
            'marca' => $marca,
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
            header('Location: /admin/productos/marcas');
        }
        $marca = Marca::find($id);
        if (!$marca) {
            header('Location: /admin/productos/marcas');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $marca->sincronizar($_POST);
            $alertas = $marca->validar();
            if (empty($alertas)) {
                $resultado = $marca->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/marcas');
                }
            }
        }
        $router->render('admin/marcas/editar', [
            'titulo' => 'Actualizar Marca',
            'alertas' => $alertas,
            'marca' => $marca,
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $marca = Marca::find($id);
            if (!isset($marca)) {
                header('Location: /admin/productos/marcas');
            }
            $resultado = $marca->eliminar();
            if ($resultado) {
                header('Location: /admin/productos/marcas');
            }
        }
    }
}
