<!-- Left Panel -->

<aside id="left-panel" class="left-panel">
    <nav class="navbar navbar-expand-sm navbar-default">

        <div class="navbar-header">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-menu" aria-controls="main-menu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fa fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?= $this->siteUrl() ?>"><img src="<?= $this->siteUrl('images/logo.png') ?>" alt="Logo"></a>
            <a class="navbar-brand hidden" href="<?= $this->siteUrl() ?>"><img src="<?= $this->siteUrl('images/logo2.png') ?>" alt="Logo"></a>
        </div>

        <div id="main-menu" class="main-menu collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="<?= $this->siteUrl() ?>index.html"> <i class="menu-icon fa fa-dashboard"></i>Dashboard </a>
                </li>
                <h3 class="menu-title">Partes</h3><!-- /.menu-title -->
                <li>
                    <a href="<?= $this->siteUrl('viagens') ?>"> <i class="menu-icon fas fa-road"></i> Viagens </a>
                    <a href="<?= $this->siteUrl('empresas') ?>"> <i class="menu-icon far fa-building"></i> Empresas</a>
                    <a href="<?= $this->siteUrl('clientes') ?>"> <i class="menu-icon fas fa-user-tag"></i> Clientes</a>
                    <a href="<?= $this->siteUrl('pedidos') ?>"> <i class="menu-icon fas fa-file-invoice-dollar"></i> Pedidos</a>
                    <a href="<?= $this->siteUrl('usuarios') ?>"><i class="menu-icon fas fa-file-invoice-dollar"></i> Usuarios</a>
                    <li class="menu-item-has-children dropdown show">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <i class="menu-icon fas fa-bus"></i>Viculos</a>
                        <ul class="sub-menu children dropdown-menu show">
                            <li><i class="menu-icon fas fa-tasks active"></i><a href="<?= $this->siteUrl('veiculos/tipo') ?>">Tipos </a></li>
                            <li><i class="menu-icon fas fa-list"></i><a href="<?= $this->siteUrl('veiculos') ?>">Lista </a></li>
                        </ul>
                    </li>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </nav>
</aside><!-- /#left-panel -->
<!-- Left Panel -->