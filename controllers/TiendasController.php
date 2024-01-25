<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Tienda;

class TiendasController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/tiendas?page=1');
        }
        $por_pagina = 1;
        $total = Tienda::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $tiendas = Tienda::paginar($por_pagina, $paginacion->offset());
        $router->render('admin/tiendas/index', [
            'titulo' => 'Tiendas',
            'tiendas' => $tiendas,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $tienda = new Tienda;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/tiendas';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $nombre_imagen = md5(uniqid(rand(), true));
                $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                $_POST['imagen'] = $nombre_imagen;
            }
            $tienda->sincronizar($_POST);
            $alertas = $tienda->validar();
            if (empty($alertas)) {
                $resultado = $tienda->guardar();
                if ($resultado) {
                    header('Location: /admin/tiendas');
                    return;
                }
            }
        }
        $router->render('admin/tiendas/crear', [
            'titulo' => 'Registrar Tienda',
            'alertas' => $alertas,
            'tienda' => $tienda
        ]);
    }

    public static function editar(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
            return;
        }
        $alertas = [];
        $id = $_GET['id'];
        $id = filter_var($id, FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: /admin/tiendas');
            return;
        }
        $tienda = Tienda::find($id);
        if (!$tienda) {
            header('Location: /admin/tiendas');
            return;
        }
        $tienda->imagen_actual = $tienda->imagen;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/tiendas';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $tienda->imagen_actual;
            }
            $tienda->sincronizar($_POST);
            $alertas = $tienda->validar();
            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                $resultado = $tienda->guardar();
                if ($resultado) {
                    header('Location: /admin/tiendas');
                    return;
                }
            }
        }
        $router->render('admin/tiendas/editar', [
            'titulo' => 'Editar Tienda',
            'alertas' => $alertas,
            'tienda' => $tienda
        ]);
    }

    public static function eliminar()
    {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            $id = $_POST['id'];
            $tienda = Tienda::find($id);
            if (!isset($tienda)) {
                header('Location: /admin/tiendas');
                return;
            }
            $resultado = $tienda->eliminar();
            if ($resultado) {
                header('Location: /admin/tiendas');
                return;
            }
        }
    }
}
