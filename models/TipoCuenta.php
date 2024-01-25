<?php

namespace Model;

class TipoCuenta extends ActiveRecord
{
    protected static $tabla = 'tipos_cuenta';
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
            self::$alertas['error'][] = 'El Tipo de la cuenta es Obligatorio';
        }
        return self::$alertas;
    }
}
