<aside class="dashboard__sidebar">
    <nav class="dashboard__menu">
        <a href="/admin/tiendas" class="dashboard__enlace <?php echo pagina_actual('/admin/tiendas') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-house dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Inicio
            </span>
        </a>

        <a href="/admin/productos" class="dashboard__enlace <?php echo pagina_actual('/admin/productos') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-box dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Productos
            </span>
        </a>

        <a href="/admin/clientes" class="dashboard__enlace <?php echo pagina_actual('/admin/clientes') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-users dashboard__icono"></i>
            <span class="dashboard__menu-texto">
                Clientes
            </span>
        </a>

        <a href="/admin/proveedores" class="dashboard__enlace <?php echo pagina_actual('/admin/proveedores') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-truck-field"></i>
            <span class="dashboard__menu-texto">
                Proveedores
            </span>
        </a>

        <a href="/admin/entradas" class="dashboard__enlace <?php echo pagina_actual('/admin/entradas') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-truck-ramp-box"></i>
            <span class="dashboard__menu-texto">
                Entradas
            </span>
        </a>

        <a href="/admin/proformas" class="dashboard__enlace <?php echo pagina_actual('/admin/proformas') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-clipboard-list"></i>
            <span class="dashboard__menu-texto">
                Proformas
            </span>
        </a>

        <a href="/admin/facturas" class="dashboard__enlace <?php echo pagina_actual('/admin/facturas') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span class="dashboard__menu-texto">
                Facturas
            </span>
        </a>

        <a href="/admin/boletas" class="dashboard__enlace <?php echo pagina_actual('/admin/boletas') ? 'dashboard__enlace--actual' : '' ?>">
            <i class="fa-solid fa-file-invoice-dollar"></i>
            <span class="dashboard__menu-texto">
                Boletas
            </span>
        </a>
    </nav>
</aside>