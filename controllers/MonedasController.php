<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Moneda;
use MVC\Router;

class MonedasController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/monedas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Moneda::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/monedas?page=1');
        }
        $monedas = Moneda::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/monedas/index', [
            'titulo' => 'Monedas',
            'paginacion' => $paginacion->paginacion(),
            'monedas' => $monedas
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $moneda = new Moneda;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $moneda->sincronizar($_POST);
            $alertas = $moneda->validar();
            if (empty($alertas)) {
                $resultado = $moneda->guardar();
                if ($resultado) {
                    header('Location: /admin/monedas');
                    return;
                }
            }
        }
        $router->render('admin/monedas/crear', [
            'titulo' => 'Registrar Moneda',
            'alertas' => $alertas,
            'moneda' => $moneda,
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
            header('Location: /admin/monedas');
        }
        $moneda = Moneda::find($id);
        if (!$moneda) {
            header('Location: /admin/monedas');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $moneda->sincronizar($_POST);
            $alertas = $moneda->validar();
            if (empty($alertas)) {
                $resultado = $moneda->guardar();
                if ($resultado) {
                    header('Location: /admin/monedas');
                }
            }
        }
        $router->render('admin/monedas/editar', [
            'titulo' => 'Actualizar Moneda',
            'alertas' => $alertas,
            'moneda' => $moneda,
        ]);
    }

    public static function eliminar()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $moneda = Moneda::find($id);
            if (!isset($moneda)) {
                header('Location: /admin/monedas');
            }
            $resultado = $moneda->eliminar();
            if ($resultado) {
                header('Location: /admin/monedas');
            }
        }
    }
}
