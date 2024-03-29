<?php

namespace Controllers;

use Classes\Paginacion;
use Model\Producto;
use MVC\Router;
use Intervention\Image\ImageManagerStatic as Image;
use Model\Categoria;
use Model\Marca;
use Model\Unidad;

class ProductosController
{
    public static function index(Router $router)
    {
        $pagina_actual = $_GET['page'];
        $pagina_actual = filter_var($pagina_actual, FILTER_VALIDATE_INT);
        if (!$pagina_actual) {
            header('Location: /admin/productos?page=1');
        }
        $por_pagina = 5;
        $total = Producto::total();
        $paginacion = new Paginacion($pagina_actual, $por_pagina, $total);
        $productos = Producto::paginar($por_pagina, $paginacion->offset());
        $router->render('admin/productos/index', [
            'titulo' => 'Productos',
            'productos' => $productos,
            'paginacion' => $paginacion->paginacion()
        ]);
    }

    public static function crear(Router $router)
    {
        $alertas = [];
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $unidades = Unidad::all();
        $producto = new Producto;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/productos';
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
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            if (empty($alertas)) {
                $producto->guardar();
                header('Location: /admin/productos');
            }
        }
        $router->render('admin/productos/crear', [
            'titulo' => 'Registrar Producto',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'unidades' => $unidades,
            'producto' => $producto
        ]);
    }

    public static function editar(Router $router)
    {
        $alertas = [];
        $id = $_GET['id'];
        $categorias = Categoria::all();
        $marcas = Marca::all();
        $unidades = Unidad::all();
        $producto = Producto::find($id);
        $producto->imagen_actual = $producto->imagen;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_FILES['imagen']['tmp_name'])) {
                $carpeta_imagenes = '../public/img/productos';
                if (!is_dir($carpeta_imagenes)) {
                    mkdir($carpeta_imagenes, 0755, true);
                }
                $imagen_png = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('png', 80);
                $imagen_webp = Image::make($_FILES['imagen']['tmp_name'])->fit(800, 800)->encode('webp', 80);
                $nombre_imagen = md5(uniqid(rand(), true));
                $_POST['imagen'] = $nombre_imagen;
            } else {
                $_POST['imagen'] = $producto->imagen_actual;
            }
            $producto->sincronizar($_POST);
            $alertas = $producto->validar();
            if (empty($alertas)) {
                if (isset($nombre_imagen)) {
                    $imagen_png->save($carpeta_imagenes . '/' . $nombre_imagen . ".png");
                    $imagen_webp->save($carpeta_imagenes . '/' . $nombre_imagen . ".webp");
                }
                $producto->guardar();
                header('Location: /admin/productos');
            }
        }
        $router->render('admin/productos/editar', [
            'titulo' => 'Editar Producto',
            'alertas' => $alertas,
            'categorias' => $categorias,
            'marcas' => $marcas,
            'unidades' => $unidades,
            'producto' => $producto
        ]);
    }

    public static function eliminar()
    {
        $id = $_POST['id'];
        $producto = Producto::find($id);
        $resultado = $producto->eliminar();
        header('Location: /admin/productos');
    }
}
