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
}
