<?php

namespace Model;

class Proforma extends ActiveRecord
{
    protected static $tabla = 'proformas';
    protected static $columnasDB = ['id', 'nombre_solicitante', 'fecha', 'subtotal', 'igv', 'total', 'tienda_id'];
    public $id;
    public $nombre_solicitante;
    public $fecha;
    public $tienda_id;
    public $subtotal;
    public $igv;
    public $total;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre_solicitante = $args['nombre_solicitante'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->igv = $args['igv'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
    }

    public static function buscar($id)
    {
        $query = "SELECT proformas.id, proformas.nombre_solicitante, proformas.fecha, proformas.subtotal, proformas.igv, proformas.total, 
        tiendas.nombre as tienda_nombre, tiendas.direccion as tienda_direccion, tiendas.telefono as tienda_telefono, tiendas.celular as tienda_celular, tiendas.imagen as tienda_imagen
        FROM proformas
        LEFT JOIN tiendas ON tiendas.id = $id
        WHERE proformas.id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

    public static function buscar_todas($por_pagina, $offset)
    {
        $query = "SELECT proformas.id, proformas.nombre_solicitante, proformas.fecha, proformas.subtotal, proformas.igv, proformas.total
        FROM proformas
        ORDER BY proformas.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
