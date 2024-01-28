<?php

namespace Model;

class Boleta extends ActiveRecord
{
    protected static $tabla = 'boletas';
    protected static $columnasDB = ['id', 'fecha', 'total', 'subtotal', 'igv', 'tienda_id', 'cliente_id'];
    public $id;
    public $fecha;
    public $total;
    public $subtotal;
    public $igv;
    public $tienda_id;
    public $cliente_id;
    public $cliente_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->igv = $args['igv'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->cliente_nombre = $args['cliente_nombre'] ?? null;
    }

    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT boletas.id, DATE_FORMAT(boletas.fecha, '%d/%m/%Y - %H:%i:%s') AS fecha, boletas.total, boletas.subtotal, boletas.igv,
        clientes.nombre as cliente_nombre
        FROM boletas
        LEFT JOIN clientes ON clientes.id = cliente_id 
        ORDER BY boletas.id DESC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function buscar($id)
    {
        $query = "SELECT boletas.id, boletas.fecha, boletas.subtotal, boletas.igv, boletas.total, clientes.nombre as cliente_nombre
        FROM boletas
        LEFT JOIN clientes ON clientes.id = cliente_id
        WHERE boletas.id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
}
