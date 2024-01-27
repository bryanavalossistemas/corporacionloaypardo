<?php

namespace Model;

class Factura extends ActiveRecord
{
    protected static $tabla = 'facturas';
    protected static $columnasDB = ['id', 'comprobante_id'];
    public $id;
    public $comprobante_id;
    public $fecha;
    public $subtotal;
    public $igv;
    public $total;
    public $cliente_id;
    public $tienda_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->comprobante_id = $args['comprobante_id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->igv = $args['igv'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
    }

    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT SELECT facturas.id, comprobantes.fecha as fecha, comprobantes.subtotal, comprobantes.igv, comprobantes.total, tiendas.nombre as tienda_nombre, 
        tiendas.direccion as tienda_direccion, tiendas.telefono as tienda_telefono, tiendas.celular as tienda_celular, tiendas.imagen as tienda_imagen 
        FROM " . static::$tabla . " ORDER BY id DESC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function buscar($id)
    {
        $query = "SELECT comprobantes.id, comprobantes.nombre_solicitante, comprobantes.fecha, comprobantes.subtotal, comprobantes.igv, comprobantes.total, 
        tiendas.nombre as tienda_nombre, tiendas.direccion as tienda_direccion, tiendas.telefono as tienda_telefono, tiendas.celular as tienda_celular, tiendas.imagen as tienda_imagen
        FROM comprobantes
        LEFT JOIN tiendas ON tiendas.id = $id
        WHERE comprobantes.id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function buscar_todas($por_pagina, $offset)
    {
        $query = "SELECT comprobantes.id, comprobantes.nombre_solicitante, comprobantes.fecha, comprobantes.subtotal, comprobantes.igv, comprobantes.total
        FROM proformas
        ORDER BY proformas.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
