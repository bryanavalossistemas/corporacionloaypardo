<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Metodo;
use MVC\Router;

class MetodosController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/facturas/metodos?page=1');
        }
        $registros_por_pagina = 5;
        $total = Metodo::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $metodos = Metodo::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/metodos/index', [
            'titulo' => 'Metodos de Pago',
            'paginacion' => $paginacion->paginacion(),
            'metodos' => $metodos
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $metodo = new Metodo;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodo->sincronizar($_POST);
            $alertas = $metodo->validar();
            if (empty($alertas)) {
                $metodo->guardar();
                header('Location: /admin/facturas/metodos');
            }
        }
        $router->render('admin/metodos/crear', [
            'titulo' => 'Registrar Metodo de Pago',
            'alertas' => $alertas,
            'metodo' => $metodo,
        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];
        $id = $_GET['id'];
        $metodo = Metodo::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $metodo->sincronizar($_POST);
            $alertas = $metodo->validar();
            if (empty($alertas)) {
                $metodo->guardar();
                header('Location: /admin/facturas/metodos');
            }
        }
        $router->render('admin/metodos/editar', [
            'titulo' => 'Actualizar Metodo',
            'alertas' => $alertas,
            'metodo' => $metodo,
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $metodo = Metodo::find($id);
        $metodo->eliminar();
        header('Location: /admin/facturas/metodos');
    }
}
