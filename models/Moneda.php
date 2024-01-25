<?php

namespace Model;

class Moneda extends ActiveRecord
{
    protected static $tabla = 'monedas';
    protected static $columnasDB = ['id', 'nombre'];
    public $id;
    public $nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre de la Moneda es Obligatorio';
        }
        return self::$alertas;
    }
}
