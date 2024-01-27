<?php

namespace Model;

class ProductoProforma extends ActiveRecord
{
    protected static $tabla = 'productos_proformas';
    protected static $columnasDB = ['id', 'precio_unitario', 'cantidad', 'descuento', 'importe', 'proforma_id', 'producto_id'];
    public $id;
    public $precio_unitario;
    public $cantidad;
    public $descuento;
    public $importe;
    public $proforma_id;
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
        $this->proforma_id = $args['proforma_id'] ?? null;
        $this->producto_id = $args['producto_id'] ?? null;
        $this->producto_imagen = $args['producto_imagen'] ?? null;
        $this->producto_nombre = $args['producto_nombre'] ?? null;
    }

    public static function obtener_todos($id)
    {
        $query = "SELECT productos_proformas.id, productos_proformas.precio_unitario, productos_proformas.cantidad, productos_proformas.descuento, productos_proformas.importe, productos.nombre as producto_nombre, productos.imagen as producto_imagen
        FROM productos_proformas
        LEFT JOIN productos ON productos.id = producto_id
        WHERE proforma_id=$id 
        ORDER BY productos_proformas.id DESC";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function obtener_valores($id)
    {
        $query = "SELECT SUM(importe) AS total, ROUND(SUM(importe) * 0.18, 2) AS igv, ROUND(SUM(importe) * 0.82, 2) AS subtotal
        FROM productos_proformas
        WHERE proforma_id=$id";
        $resultado = self::$db->query($query);
        $data = [...$resultado];
        $resultado->free();
        return array_shift($data);
    }
}
