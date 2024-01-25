<?php

namespace Model;

class ProductoEntrada extends ActiveRecord
{
    protected static $tabla = 'productos_entradas';
    protected static $columnasDB = ['id', 'cantidad', 'entrada_id', 'producto_id'];
    public $id;
    public $cantidad;
    public $entrada_id;
    public $producto_id;
    public $producto_imagen;
    public $producto_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->entrada_id = $args['entrada_id'] ?? null;
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_imagen = $args['producto_imagen'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? null;
    }

    public static function obtener_todos($id)
    {
        $query = "SELECT productos_entradas.id, productos_entradas.cantidad, productos.nombre as producto_nombre, productos.imagen as producto_imagen
        FROM productos_entradas
        LEFT JOIN productos ON productos.id = producto_id
        WHERE entrada_id=$id 
        ORDER BY productos_entradas.id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
