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
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual) {
            header('Location: /admin/clientes?page=1');
        }
        $por_pagina = 5;
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
        $alertas = [];
        $cliente = new Cliente;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $cliente->guardar();
                header('Location: /admin/clientes');
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
        $alertas = [];
        $id = $_GET['id'];
        $cliente = Cliente::find($id);
        $cliente->imagen_actual = $cliente->imagen;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
                $cliente->guardar();
                header('Location: /admin/clientes');
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
        $id = $_POST['id'];
        $cliente = Cliente::find($id);
        $cliente->eliminar();
        header('Location: /admin/clientes');
    }
}
