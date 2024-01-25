<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Categoria;
use MVC\Router;

class CategoriasController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/productos/categorias?page=1');
        }
        $registros_por_pagina = 5;
        $total = Categoria::total();
        $paginacion = new Paginacion($pagina_actual, $registros_por_pagina, $total);
        if ($paginacion->total_paginas() < $pagina_actual) {
            header('Location: /admin/productos/categorias?page=1');
        }
        $categorias = Categoria::paginar($registros_por_pagina, $paginacion->offset());
        $router->render('admin/categorias/index', [
            'titulo' => 'Categorías',
            'paginacion' => $paginacion->paginacion(),
            'categorias' => $categorias
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $categoria = new Categoria;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();
            if (empty($alertas)) {
                $resultado = $categoria->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/categorias');
                    return;
                }
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
        if (!is_admin()) {
            header('Location: /login');
        }
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/productos/categorias');
        }
        $categoria = Categoria::find($id);
        if (!$categoria) {
            header('Location: /admin/productos/categorias');
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $categoria->sincronizar($_POST);
            $alertas = $categoria->validar();
            if (empty($alertas)) {
                $resultado = $categoria->guardar();
                if ($resultado) {
                    header('Location: /admin/productos/categorias');
                }
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
            }
            $id = $_POST['id'];
            $categoria = Categoria::find($id);
            if (!isset($categoria)) {
                header('Location: /admin/productos/categorias');
            }
            $resultado = $categoria->eliminar();
            if ($resultado) {
                header('Location: /admin/productos/categorias');
            }
        }
    }
}
