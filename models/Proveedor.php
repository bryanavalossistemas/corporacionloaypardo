<?php

namespace Model;

class Proveedor extends ActiveRecord
{
    protected static $tabla = 'proveedores';
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
            self::$alertas['error'][] = 'El Nombre del Proveedor es Obligatorio';
        }
        if (!$this->documento) {
            self::$alertas['error'][] = 'El Numero de Documento del Proveedor es Obligatorio';
        }
        if (!$this->direccion) {
            self::$alertas['error'][] = 'La Dirección del Proveedor es Obligatorio';
        }
        return self::$alertas;
    }
}
