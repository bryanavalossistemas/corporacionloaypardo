<?php

namespace Model;

class ProductoFactura extends ActiveRecord
{
    protected static $tabla = 'productos_facturas';
    protected static $columnasDB = ['id', 'precio_unitario', 'cantidad', 'descuento', 'importe', 'factura_id', 'producto_id'];
    public $id;
    public $precio_unitario;
    public $cantidad;
    public $descuento;
    public $importe;
    public $factura_id;
    public $producto_id;
    public $producto_imagen;
    public $producto_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->precio_unitario = $args['precio_unitario'] ?? null;
        $this->cantidad = $args['cantidad'] ?? null;
        $this->descuento = $args['descuento'] ?? null;
        $this->importe = $args['importe'] ?? null;
        $this->factura_id = $args['factura_id'] ?? null;
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_imagen = $args['producto_imagen'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? null;
    }

    public static function obtener_todos($id)
    {
        $query = "SELECT productos_facturas.id, productos_facturas.precio_unitario, productos_facturas.cantidad, productos_facturas.descuento, productos_facturas.importe, 
        productos.nombre as producto_nombre, productos.imagen as producto_imagen
        FROM productos_facturas
        LEFT JOIN productos ON productos.id = producto_id
        WHERE factura_id=$id 
        ORDER BY productos_facturas.id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function obtener_valores($id)
    {
        $query = "SELECT SUM(importe) AS total, ROUND(SUM(importe) * 0.18, 2) AS igv, ROUND(SUM(importe) * 0.82, 2) AS subtotal
        FROM productos_facturas
        WHERE factura_id=$id";
        $resultado = self::$db->query($query);
        $data = [...$resultado];
        $resultado->free();
        return array_shift($data);
    }
}
