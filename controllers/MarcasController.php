<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Marca;
use MVC\Router;

class MarcasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/productos/marcas?page=1');
        }
        $registros_por_pagina = 5;
        $total = Marca::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $marcas = Marca::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/marcas/index', [
            'titulo' => 'Marcas',
            'paginacion' => $paginacion->paginacion(),
            'marcas' => $marcas
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $marca = new Marca;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca->sincronizar($_POST);
            $alertas = $marca->validar();
            if (empty($alertas)) {
                $resultado = $marca->guardar();
                header('Location: /admin/productos/marcas');
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
        $alertas = [];
        $id = $_GET['id'];
        $marca = Marca::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $marca->sincronizar($_POST);
            $alertas = $marca->validar();
            if (empty($alertas)) {
                $resultado = $marca->guardar();
                header('Location: /admin/productos/marcas');
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
        $id = $_POST['id'];
        $marca = Marca::find($id);
        $resultado = $marca->eliminar();
        header('Location: /admin/productos/marcas');
    }
}
