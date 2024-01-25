<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Proveedor;

class ProveedoresController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/proveedores?page=1');
        }
        $por_pagina = 1;
        $total = Proveedor::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $proveedores = Proveedor::paginar($por_pagina, $paginacion->offset());
        $router->render('admin/proveedores/index', [
            'titulo' => 'Proveedores',
            'proveedores' => $proveedores,
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
        $proveedor = new Proveedor;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/proveedores';
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
            $proveedor->sincronizar($_POST);
            $alertas = $proveedor->validar();
            if (empty($alertas)) {
                $resultado = $proveedor->guardar();
                if ($resultado) {
                    header('Location: /admin/proveedores');
                    return;
                }
            }
        }
        $router->render('admin/proveedores/crear', [
            'titulo' => 'Registrar Proveedor',
            'alertas' => $alertas,
            'proveedor' => $proveedor
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
            header('Location: /admin/proveedores');
            return;
        }
        $proveedor = Proveedor::find($id);
        if (!$proveedor) {
            header('Location: /admin/proveedores');
            return;
        }
        $proveedor->imagen_actual = $proveedor->imagen;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/proveedores';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $proveedor->imagen_actual;
            }
            $proveedor->sincronizar($_POST);
            $alertas = $proveedor->validar();
            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                $resultado = $proveedor->guardar();
                if ($resultado) {
                    header('Location: /admin/proveedores');
                    return;
                }
            }
        }
        $router->render('admin/proveedores/editar', [
            'titulo' => 'Editar Proveedor',
            'alertas' => $alertas,
            'proveedor' => $proveedor
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
            $proveedor = Proveedor::find($id);
            if (!isset($proveedor)) {
                header('Location: /admin/proveedores');
                return;
            }
            $resultado = $proveedor->eliminar();
            if ($resultado) {
                header('Location: /admin/proveedores');
                return;
            }
        }
    }
}
