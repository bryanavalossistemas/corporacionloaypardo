<?php

namespace Model;

class CuentaProveedor extends ActiveRecord
{
    protected static $tabla = 'cuentas_proveedor';
    protected static $columnasDB = ['id', 'numero', 'tipo_cuenta_id', 'banco_id', 'moneda_id', 'proveedor_id'];
    public $id;
    public $numero;
    public $tipo_cuenta_id;
    public $banco_id;
    public $moneda_id;
    public $proveedor_id;
    public $tipo_cuenta;
    public $banco;
    public $moneda;
    public $proveedor;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->numero = $args['numero'] ?? null;
        $this->tipo_cuenta_id = $args['tipo_cuenta_id'] ?? null;
        $this->banco_id = $args['banco_id'] ?? null;
        $this->moneda_id = $args['moneda_id'] ?? null;
        $this->proveedor_id = $args['proveedor_id'] ?? null;
        $this->tipo_cuenta = $args['tipo_cuenta'] ?? null;
        $this->banco = $args['banco'] ?? null;
        $this->moneda = $args['moneda'] ?? null;
        $this->proveedor = $args['proveedor'] ?? null;
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

    public static function paginar_id($por_pagina, $offset, $id = '')
    {
        $query = "SELECT cuentas_proveedor.id, cuentas_proveedor.numero, tipos_cuenta.nombre as tipo_cuenta, bancos.nombre as banco, monedas.nombre as moneda, proveedores.nombre as proveedor
        FROM cuentas_proveedor
        LEFT JOIN tipos_cuenta ON tipos_cuenta.id = tipo_cuenta_id
        LEFT JOIN bancos ON bancos.id = banco_id
        LEFT JOIN monedas ON monedas.id = moneda_id
        LEFT JOIN proveedores ON proveedores.id = proveedor_id
        WHERE proveedor_id=$id 
        ORDER BY cuentas_proveedor.id ASC LIMIT $por_pagina OFFSET $offset";
        $resultado = self::consultarSQL($query);
        return $resultado;
    }
}
