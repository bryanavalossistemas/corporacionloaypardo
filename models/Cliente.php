<?php

namespace Model;

class Cliente extends ActiveRecord
{
    protected static $tabla = 'clientes';
    protected static $columnasDB = ['id', 'nombre', 'documento', 'direccion', 'telefono', 'celular', 'correo', 'imagen'];
    public $id;
    public $nombre;
    public $documento;
    public $direccion;
    public $telefono;
    public $celular;
    public $correo;
    public $imagen;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->documento = $args['documento'] ?? null;
        $this->direccion = $args['direccion'] ?? null;
        $this->telefono = $args['telefono'] ?? null;
        $this->celular = $args['celular'] ?? null;
        $this->correo = $args['correo'] ?? null;
        $this->imagen = $args['imagen'] ?? null;
    }

    public function validar()
    {
        if (!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Cliente es Obligatorio';
        }
        if (!$this->documento) {
            self::$alertas['error'][] = 'El Numero de Documento del Cliente es Obligatorio';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La Dirección del Cliente es Obligatorio';
        }
        return self::$alertas;
    }
}
