<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Moneda;
use MVC\Router;

class MonedasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/monedas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Moneda::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $monedas = Moneda::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/monedas/index', [
            'titulo' => 'Monedas',
            'paginacion' => $paginacion->paginacion(),
            'monedas' => $monedas
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $moneda = new Moneda;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $moneda->sincronizar($_POST);
            $alertas = $moneda->validar();
            if (empty($alertas)) {
                $resultado = $moneda->guardar();
                header('Location: /admin/monedas');
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
        $alertas = [];
        $id = $_GET['id'];
        $moneda = Moneda::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $moneda->sincronizar($_POST);
            $alertas = $moneda->validar();
            if (empty($alertas)) {
                $resultado = $moneda->guardar();
                header('Location: /admin/monedas');
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
        $id = $_POST['id'];
        $moneda = Moneda::find($id);
        $resultado = $moneda->eliminar();
        header('Location: /admin/monedas');
    }
}
