<?php

namespace Controllers;

use Classes\Paginacion;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Cliente;

class ClientesController
{
    public static function index(Router $router)
    {
        if (!is_admin()) {
            header('Location: /login');
        }
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual || $pagina_actual < 1) {
            header('Location: /admin/clientes?page=1');
        }
        $por_pagina = 1;
        $total = Cliente::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $clientes = Cliente::paginar($por_pagina, $paginacion->offset());
        $router->render('admin/clientes/index', [
            'titulo' => 'Clientes',
            'clientes' => $clientes,
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
        $cliente = new Cliente;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/clientes';
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
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar();
            if (empty($alertas)) {
                $resultado = $cliente->guardar();
                if ($resultado) {
                    header('Location: /admin/clientes');
                    return;
                }
            }
        }
        $router->render('admin/clientes/crear', [
            'titulo' => 'Registrar Cliente',
            'alertas' => $alertas,
            'cliente' => $cliente
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
            header('Location: /admin/clientes');
            return;
        }
        $cliente = Cliente::find($id);
        if (!$cliente) {
            header('Location: /admin/clientes');
            return;
        }
        $cliente->imagen_actual = $cliente->imagen;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!is_admin()) {
                header('Location: /login');
                return;
            }
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/clientes';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $cliente->imagen_actual;
            }
            $cliente->sincronizar($_POST);
            $alertas = $cliente->validar();
            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                $resultado = $cliente->guardar();
                if ($resultado) {
                    header('Location: /admin/clientes');
                    return;
                }
            }
        }
        $router->render('admin/clientes/editar', [
            'titulo' => 'Editar Cliente',
            'alertas' => $alertas,
            'cliente' => $cliente
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
            $cliente = Cliente::find($id);
            if (!isset($cliente)) {
                header('Location: /admin/clientes');
                return;
            }
            $resultado = $cliente->eliminar();
            if ($resultado) {
                header('Location: /admin/clientes');
                return;
            }
        }
    }
}
