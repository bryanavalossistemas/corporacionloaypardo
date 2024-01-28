<?php

namespace Model;

class Entrada extends ActiveRecord
{
    protected static $tabla = 'entradas';
    protected static $columnasDB = ['id', 'fecha', 'proveedor_id',];
    public $id;
    public $fecha;
    public $proveedor_id;
    public $proveedor_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->proveedor_id = $args['proveedor_id'] ?? null;
        $this->proveedor_nombre = $args['proveedor_nombre'] ?? null;
    }
    public static function paginar($por_pagina, $offset)
    {
        $query = "SELECT entradas.id, DATE_FORMAT(entradas.fecha, '%d/%m/%Y - %H:%i:%s') AS fecha, entradas.proveedor_id, proveedores.nombre as proveedor_nombre
        FROM entradas
        LEFT JOIN proveedores ON proveedores.id = proveedor_id
        ORDER BY entradas.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }

    public static function buscar($id)
    {
        $query = "SELECT entradas.id, entradas.fecha, entradas.proveedor_id, proveedores.nombre as proveedor_nombre
        FROM entradas
        LEFT JOIN proveedores ON proveedores.id = proveedor_id
        WHERE entradas.id = $id 
        ORDER BY entradas.id ASC LIMIT 1";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }

}
