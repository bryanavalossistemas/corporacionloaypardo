<?php

namespace Model;

class Factura extends ActiveRecord
{
    protected static $tabla = 'facturas';
    protected static $columnasDB = ['id', 'fecha', 'total', 'subtotal', 'igv', 'pago_id', 'tienda_id', 'cliente_id'];
    public $id;
    public $fecha;
    public $total;
    public $subtotal;
    public $igv;
    public $pago_id;
    public $tienda_id;
    public $cliente_id;
    public $cliente_nombre;
    public $metodo_nombre;
    public $forma_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->igv = $args['igv'] ?? null;
        $this->pago_id = $args['pago_id'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->cliente_nombre = $args['cliente_nombre'] ?? null;
        $this->metodo_nombre = $args['metodo_nombre'] ?? null;
        $this->forma_nombre = $args['forma_nombre'] ?? null;
    }

    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT facturas.id, DATE_FORMAT(facturas.fecha, '%d/%m/%Y - %H:%i:%s') AS fecha, facturas.total, facturas.subtotal, facturas.igv, facturas.pago_id, metodos.nombre as metodo_nombre, formas.nombre as forma_nombre,
        clientes.nombre as cliente_nombre
        FROM facturas 
        LEFT JOIN pagos ON pagos.id = pago_id
        LEFT JOIN metodos ON metodos.id = pagos.metodo_id
        LEFT JOIN formas ON formas.id = pagos.forma_id
        LEFT JOIN clientes ON clientes.id = cliente_id 
        ORDER BY facturas.id DESC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function buscar($id)
    {
        $query = "SELECT facturas.id, facturas.fecha, facturas.subtotal, facturas.igv, facturas.total, facturas.pago_id, clientes.nombre as cliente_nombre
        FROM facturas
        LEFT JOIN clientes ON clientes.id = cliente_id
        WHERE facturas.id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
}
