<?php

require_once __DIR__ . '/../includes/app.php';

use MVC\Router;
use Controllers\AuthController;
use Controllers\BancosController;
use Controllers\BoletasController;
use Controllers\CategoriasController;
use Controllers\ClientesController;
use Controllers\CuentasProveedorController;
use Controllers\CuentasTiendaController;
use Controllers\EntradasController;
use Controllers\FacturasController;
use Controllers\FormasController;
use Controllers\MarcasController;
use Controllers\MetodosController;
use Controllers\MonedasController;
use Controllers\ProductosController;
use Controllers\ProformasController;
use Controllers\ProveedoresController;
use Controllers\TiendasController;
use Controllers\TiposCuentaController;
use Controllers\UnidadesController;

$router = new Router();

// Login
$router->get('/', [AuthController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);
$router->post('/login', [AuthController::class, 'login']);
$router->post('/logout', [AuthController::class, 'logout']);
$router->get('/registro', [AuthController::class, 'registro']);
$router->post('/registro', [AuthController::class, 'registro']);
$router->get('/olvide', [AuthController::class, 'olvide']);
$router->post('/olvide', [AuthController::class, 'olvide']);
$router->get('/reestablecer', [AuthController::class, 'reestablecer']);
$router->post('/reestablecer', [AuthController::class, 'reestablecer']);
$router->get('/mensaje', [AuthController::class, 'mensaje']);
$router->get('/confirmar-cuenta', [AuthController::class, 'confirmar']);

// Productos
$router->get('/admin/productos', [ProductosController::class, 'index']);
$router->get('/admin/productos/crear', [ProductosController::class, 'crear']);
$router->post('/admin/productos/crear', [ProductosController::class, 'crear']);
$router->get('/admin/productos/editar', [ProductosController::class, 'editar']);
$router->post('/admin/productos/editar', [ProductosController::class, 'editar']);
$router->post('/admin/productos/eliminar', [ProductosController::class, 'eliminar']);

// Clientes
$router->get('/admin/clientes', [ClientesController::class, 'index']);
$router->get('/admin/clientes/crear', [ClientesController::class, 'crear']);
$router->post('/admin/clientes/crear', [ClientesController::class, 'crear']);
$router->get('/admin/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/admin/clientes/editar', [ClientesController::class, 'editar']);
$router->post('/admin/clientes/eliminar', [ClientesController::class, 'eliminar']);

// Tiendas
$router->get('/admin/tiendas', [TiendasController::class, 'index']);
$router->get('/admin/tiendas/crear', [TiendasController::class, 'crear']);
$router->post('/admin/tiendas/crear', [TiendasController::class, 'crear']);
$router->get('/admin/tiendas/editar', [TiendasController::class, 'editar']);
$router->post('/admin/tiendas/editar', [TiendasController::class, 'editar']);
$router->post('/admin/tiendas/eliminar', [TiendasController::class, 'eliminar']);

// CuentasTienda
$router->get('/admin/tiendas/cuentas_tienda', [CuentasTiendaController::class, 'index']);
$router->get('/admin/tiendas/cuentas_tienda/crear', [CuentasTiendaController::class, 'crear']);
$router->post('/admin/tiendas/cuentas_tienda/crear', [CuentasTiendaController::class, 'crear']);
$router->get('/admin/tiendas/cuentas_tienda/editar', [CuentasTiendaController::class, 'editar']);
$router->post('/admin/tiendas/cuentas_tienda/editar', [CuentasTiendaController::class, 'editar']);
$router->post('/admin/tiendas/cuentas_tienda/eliminar', [CuentasTiendaController::class, 'eliminar']);

// CuentasTienda
$router->get('/admin/proveedores/cuentas_proveedor', [CuentasProveedorController::class, 'index']);
$router->get('/admin/proveedores/cuentas_proveedor/crear', [CuentasProveedorController::class, 'crear']);
$router->post('/admin/proveedores/cuentas_proveedor/crear', [CuentasProveedorController::class, 'crear']);
$router->get('/admin/proveedores/cuentas_proveedor/editar', [CuentasProveedorController::class, 'editar']);
$router->post('/admin/proveedores/cuentas_proveedor/editar', [CuentasProveedorController::class, 'editar']);
$router->post('/admin/proveedores/cuentas_proveedor/eliminar', [CuentasProveedorController::class, 'eliminar']);

// Proveedores
$router->get('/admin/proveedores', [ProveedoresController::class, 'index']);
$router->get('/admin/proveedores/crear', [ProveedoresController::class, 'crear']);
$router->post('/admin/proveedores/crear', [ProveedoresController::class, 'crear']);
$router->get('/admin/proveedores/editar', [ProveedoresController::class, 'editar']);
$router->post('/admin/proveedores/editar', [ProveedoresController::class, 'editar']);
$router->post('/admin/proveedores/eliminar', [ProveedoresController::class, 'eliminar']);

//Categorias
$router->get('/admin/productos/categorias', [CategoriasController::class, 'index']);
$router->get('/admin/productos/categorias/crear', [CategoriasController::class, 'crear']);
$router->post('/admin/productos/categorias/crear', [CategoriasController::class, 'crear']);
$router->get('/admin/productos/categorias/editar', [CategoriasController::class, 'editar']);
$router->post('/admin/productos/categorias/editar', [CategoriasController::class, 'editar']);
$router->post('/admin/productos/categorias/eliminar', [CategoriasController::class, 'eliminar']);

// Unidades
$router->get('/admin/productos/unidades', [UnidadesController::class, 'index']);
$router->get('/admin/productos/unidades/crear', [UnidadesController::class, 'crear']);
$router->post('/admin/productos/unidades/crear', [UnidadesController::class, 'crear']);
$router->get('/admin/productos/unidades/editar', [UnidadesController::class, 'editar']);
$router->post('/admin/productos/unidades/editar', [UnidadesController::class, 'editar']);
$router->post('/admin/productos/unidades/eliminar', [UnidadesController::class, 'eliminar']);

// Marcas
$router->get('/admin/productos/marcas', [MarcasController::class, 'index']);
$router->get('/admin/productos/marcas/crear', [MarcasController::class, 'crear']);
$router->post('/admin/productos/marcas/crear', [MarcasController::class, 'crear']);
$router->get('/admin/productos/marcas/editar', [MarcasController::class, 'editar']);
$router->post('/admin/productos/marcas/editar', [MarcasController::class, 'editar']);
$router->post('/admin/productos/marcas/eliminar', [MarcasController::class, 'eliminar']);

// Bancos
$router->get('/admin/bancos', [BancosController::class, 'index']);
$router->get('/admin/bancos/crear', [BancosController::class, 'crear']);
$router->post('/admin/bancos/crear', [BancosController::class, 'crear']);
$router->get('/admin/bancos/editar', [BancosController::class, 'editar']);
$router->post('/admin/bancos/editar', [BancosController::class, 'editar']);
$router->post('/admin/bancos/eliminar', [BancosController::class, 'eliminar']);

// Monedas
$router->get('/admin/monedas', [MonedasController::class, 'index']);
$router->get('/admin/monedas/crear', [MonedasController::class, 'crear']);
$router->post('/admin/monedas/crear', [MonedasController::class, 'crear']);
$router->get('/admin/monedas/editar', [MonedasController::class, 'editar']);
$router->post('/admin/monedas/editar', [MonedasController::class, 'editar']);
$router->post('/admin/monedas/eliminar', [MonedasController::class, 'eliminar']);

// Tipos_cuenta
$router->get('/admin/tipos_cuenta', [TiposCuentaController::class, 'index']);
$router->get('/admin/tipos_cuenta/crear', [TiposCuentaController::class, 'crear']);
$router->post('/admin/tipos_cuenta/crear', [TiposCuentaController::class, 'crear']);
$router->get('/admin/tipos_cuenta/editar', [TiposCuentaController::class, 'editar']);
$router->post('/admin/tipos_cuenta/editar', [TiposCuentaController::class, 'editar']);
$router->post('/admin/tipos_cuenta/eliminar', [TiposCuentaController::class, 'eliminar']);

// Metodos
$router->get('/admin/facturas/metodos', [MetodosController::class, 'index']);
$router->get('/admin/facturas/metodos/crear', [MetodosController::class, 'crear']);
$router->post('/admin/facturas/metodos/crear', [MetodosController::class, 'crear']);
$router->get('/admin/facturas/metodos/editar', [MetodosController::class, 'editar']);
$router->post('/admin/facturas/metodos/editar', [MetodosController::class, 'editar']);
$router->post('/admin/facturas/metodos/eliminar', [MetodosController::class, 'eliminar']);

// Formas
$router->get('/admin/facturas/formas', [FormasController::class, 'index']);
$router->get('/admin/facturas/formas/crear', [FormasController::class, 'crear']);
$router->post('/admin/facturas/formas/crear', [FormasController::class, 'crear']);
$router->get('/admin/facturas/formas/editar', [FormasController::class, 'editar']);
$router->post('/admin/facturas/formas/editar', [FormasController::class, 'editar']);
$router->post('/admin/facturas/formas/eliminar', [FormasController::class, 'eliminar']);

// Entradas
$router->get('/admin/entradas', [EntradasController::class, 'index']);
$router->get('/admin/entradas/crear', [EntradasController::class, 'crear']);
$router->post('/admin/entradas/crear', [EntradasController::class, 'crear']);
$router->get('/admin/entradas/editar', [EntradasController::class, 'editar']);
$router->post('/admin/entradas/editar', [EntradasController::class, 'editar']);
$router->post('/admin/entradas/eliminar', [EntradasController::class, 'eliminar']);
$router->get('/admin/entradas/crear_entrada_vacia', [EntradasController::class, 'crear_entrada_vacia']);
$router->get('/admin/entradas/eliminar_producto', [EntradasController::class, 'eliminar_producto']);

// Proformas
$router->get('/admin/proformas', [ProformasController::class, 'index']);
$router->get('/admin/proformas/crear', [ProformasController::class, 'crear']);
$router->post('/admin/proformas/crear', [ProformasController::class, 'crear']);
$router->get('/admin/proformas/editar', [ProformasController::class, 'editar']);
$router->post('/admin/proformas/editar', [ProformasController::class, 'editar']);
$router->post('/admin/proformas/eliminar', [ProformasController::class, 'eliminar']);
$router->get('/admin/proformas/crear_proforma_vacia', [ProformasController::class, 'crear_proforma_vacia']);
$router->get('/admin/proformas/eliminar_producto', [ProformasController::class, 'eliminar_producto']);

// Facturas
$router->get('/admin/facturas', [FacturasController::class, 'index']);
$router->get('/admin/facturas/crear', [FacturasController::class, 'crear']);
$router->post('/admin/facturas/crear', [FacturasController::class, 'crear']);
$router->get('/admin/facturas/editar', [FacturasController::class, 'editar']);
$router->post('/admin/facturas/editar', [FacturasController::class, 'editar']);
$router->post('/admin/facturas/eliminar', [FacturasController::class, 'eliminar']);
$router->get('/admin/facturas/crear_factura_vacia', [FacturasController::class, 'crear_factura_vacia']);
$router->get('/admin/facturas/eliminar_producto', [FacturasController::class, 'eliminar_producto']);

// Boletas
$router->get('/admin/boletas', [BoletasController::class, 'index']);
$router->get('/admin/boletas/crear', [BoletasController::class, 'crear']);
$router->post('/admin/boletas/crear', [BoletasController::class, 'crear']);
$router->get('/admin/boletas/editar', [BoletasController::class, 'editar']);
$router->post('/admin/boletas/editar', [BoletasController::class, 'editar']);
$router->post('/admin/boletas/eliminar', [BoletasController::class, 'eliminar']);
$router->get('/admin/boletas/crear_boleta_vacia', [BoletasController::class, 'crear_boleta_vacia']);
$router->get('/admin/boletas/eliminar_producto', [BoletasController::class, 'eliminar_producto']);

$router->comprobarRutas();
