<?php

namespace Model;

class Producto extends ActiveRecord
{
    protected static $tabla = 'productos';
    protected static $columnasDB = ['id', 'nombre', 'costo', 'venta', 'stock', 'imagen', 'categoria_id', 'marca_id', 'unidad_id'];
    public $id;
    public $nombre;
    public $costo;
    public $venta;
    public $stock;
    public $imagen;
    public $categoria_id;
    public $marca_id;
    public $unidad_id;
    public $categoria_nombre;
    public $marca_nombre;
    public $unidad_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->costo = $args['costo'] ?? null;
        $this->venta = $args['venta'] ?? null;
        $this->stock = $args['stock'] ?? null;
        $this->imagen = $args['imagen'] ?? null;
        $this->categoria_id = $args['categoria_id'] ?? null;
        $this->marca_id = $args['marca_id'] ?? null;
        $this->unidad_id = $args['unidad_id'] ?? null;
        $this->categoria_nombre = $args['categoria_nombre'] ?? null;
        $this->marca_nombre = $args['marca_nombre'] ?? null;
        $this->unidad_nombre = $args['unidad_nombre'] ?? null;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Producto es Obligatorio';
        }
        if (!$this->venta) {
            self::$alertas['error'][] = 'El Precio de Venta del Producto es Obligatorio';
        }
        return self::$alertas;
    }

    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT productos.id, productos.nombre, productos.costo, productos.venta, productos.stock, productos.imagen, categorias.nombre as categoria_nombre, marcas.nombre as marca_nombre, unidades.nombre as unidad_nombre
        FROM productos
        LEFT JOIN categorias ON categorias.id = categoria_id
        LEFT JOIN marcas ON marcas.id = marca_id
        LEFT JOIN unidades ON unidades.id = unidad_id
        ORDER BY productos.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
