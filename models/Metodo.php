<?php

namespace Model;

class Metodo extends ActiveRecord
{
    protected static $tabla = 'metodos';
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
            self::$alertas['error'][] = 'El Nombre del Metodo de Pago es Obligatorio';
        }
        return self::$alertas;
    }
}
