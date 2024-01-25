<?php

namespace Model;

class CuentaTienda extends ActiveRecord
{
    protected static $tabla = 'cuentas_tienda';
    protected static $columnasDB = ['id', 'nombre', 'numero', 'tipo_cuenta_id', 'banco_id', 'moneda_id', 'tienda_id'];
    public $id;
    public $nombre;
    public $numero;
    public $tipo_cuenta_id;
    public $banco_id;
    public $moneda_id;
    public $tienda_id;
    public $tipo_cuenta;
    public $banco;
    public $moneda;
    public $tienda;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? null;
        $this->numero = $args['numero'] ?? null;
        $this->tipo_cuenta_id = $args['tipo_cuenta_id'] ?? null;
        $this->banco_id = $args['banco_id'] ?? null;
        $this->moneda_id = $args['moneda_id'] ?? null;
        $this->tienda_id = $args['tienda_id'] ?? null;
        $this->tipo_cuenta = $args['tipo_cuenta'] ?? null;
        $this->banco = $args['banco'] ?? null;
        $this->moneda = $args['moneda'] ?? null;
        $this->tienda = $args['tienda'] ?? null;
    }

    public function validar()
    {
        if (!$this->numero) {
            self::$alertas['error'][] = 'El Numero de la Cuenta es Obligatorio';
        }
        if (!$this->tipo_cuenta_id) {
            self::$alertas['error'][] = 'El Tipo de la Cuenta es Obligatorio';
        }
        if (!$this->banco_id) {
            self::$alertas['error'][] = 'El Banco de la Cuenta es Obligatorio';
        }
        return self::$alertas;
    }

    public static function paginar_id($por_pagina, $offset, $id='')
    {
        $query = "SELECT cuentas_tienda.id, cuentas_tienda.nombre, cuentas_tienda.numero, tipos_cuenta.nombre as tipo_cuenta, bancos.nombre as banco, monedas.nombre as moneda, tiendas.nombre as tienda
        FROM cuentas_tienda
        LEFT JOIN tipos_cuenta ON tipos_cuenta.id = tipo_cuenta_id
        LEFT JOIN bancos ON bancos.id = banco_id
        LEFT JOIN monedas ON monedas.id = moneda_id
        LEFT JOIN tiendas ON tiendas.id = tienda_id
        WHERE tienda_id=$id 
        ORDER BY cuentas_tienda.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
