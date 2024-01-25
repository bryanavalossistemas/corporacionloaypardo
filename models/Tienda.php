<?php

namespace Model;

class Tienda extends ActiveRecord
{
    protected static $tabla = 'tiendas';
    protected static $columnasDB = ['id', 'nombre', 'ruc', 'direccion', 'correo', 'telefono', 'celular', 'imagen'];
    public $id;
    public $nombre;
    public $ruc;
    public $direccion;
    public $correo;
    public $telefono;
    public $celular;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->ruc = $args['ruc'] ?? null;
        $this->direccion = $args['direccion'] ?? null;
        $this->correo = $args['correo'] ?? null;
        $this->telefono = $args['telefono'] ?? null;
        $this->celular = $args['celular'] ?? null;
        $this->imagen = $args['imagen'] ?? null;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre de la Tienda es Obligatorio';
        }
        if (!$this->ruc) {
            self::$alertas['error'][] = 'El RUC de la Tienda es Obligatorio';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'El Dirección de la Tienda es Obligatorio';
        }
        return self::$alertas;
    }
}
