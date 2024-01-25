<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use MVC\Router;

class CategoriasController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        if (!$pagina_actual) {
            header('Location: /admin/productos/categorias?page=1');
        }
        $registros_por_pagina = 5;
        $total = Categoria::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        $categorias = Categoria::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/categorias/index', [
            'titulo' => 'Categorías',
            'paginacion' => $paginacion->paginacion(),
            'categorias' => $categorias
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $categoria = new Categoria;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();
            if (empty($alertas)) {
                $categoria->guardar();
                header('Location: /admin/productos/categorias');
            }
        }
        $router->render('admin/categorias/crear', [
            'titulo' => 'Registrar Categoría',
            'alertas' => $alertas,
            'categoria' => $categoria,
        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];
        $id = $_GET['id'];
        $categoria = Categoria::find($id);
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();
            if (empty($alertas)) {
                $categoria->guardar();
                header('Location: /admin/productos/categorias');
            }
        }
        $router->render('admin/categorias/editar', [
            'titulo' => 'Actualizar Categoría',
            'alertas' => $alertas,
            'categoria' => $categoria,
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $categoria = Categoria::find($id);
        $categoria->eliminar();
        header('Location: /admin/productos/categorias');
    }
}
