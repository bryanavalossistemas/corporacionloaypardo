<?php

namespace Model;

class Pago extends ActiveRecord
{
    protected static $tabla = 'pagos';
    protected static $columnasDB = ['id', 'metodo_id', 'forma_id'];
    public $id;
    public $metodo_id;
    public $forma_id;
    public $metodo_nombre;
    public $forma_nombre;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->metodo_id = $args['metodo_id'] ?? null;
        $this->forma_id = $args['forma_id'] ?? null;
        $this->metodo_nombre = $args['metodo_nombre'] ?? null;
        $this->forma_nombre = $args['forma_nombre'] ?? null;
    }

    public static function buscar($id)
    {
        $query = "SELECT pagos.id, pagos.metodo_id, pagos.forma_id, metodos.nombre as metodo_nombre, formas.nombre as forma_nombre 
        FROM pagos 
        LEFT JOIN metodos ON metodos.id = metodo_id
        LEFT JOIN formas ON formas.id = forma_id
        WHERE pagos.id = $id";
        $resultado = self::consultarSQL($query);
        return array_shift($resultado);
    }
}
