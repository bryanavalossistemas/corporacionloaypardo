<?php

namespace Model;

class Comprobante extends ActiveRecord
{
    protected static $tabla = 'comprobantes';
    protected static $columnasDB = ['id', 'fecha', 'subtotal', 'igv', 'total', 'cliente_id', 'tienda_id'];
    public $id;
    public $fecha;
    public $subtotal;
    public $igv;
    public $total;
    public $cliente_id;
    public $tienda_id;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->fecha = $args['fecha'] ?? null;
        $this->subtotal = $args['subtotal'] ?? null;
        $this->igv = $args['igv'] ?? null;
        $this->total = $args['total'] ?? null;
        $this->cliente_id = $args['cliente_id'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
    }
}
