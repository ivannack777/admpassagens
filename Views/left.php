
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
                    <h3 class="menu-title">UI elements</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-laptop"></i>Components</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-puzzle-piece"></i><a href="<?= $this->siteUrl() ?>ui-buttons.html">Buttons</a></li>
                            <li><i class="fa fa-id-badge"></i><a href="<?= $this->siteUrl() ?>ui-badges.html">Badges</a></li>
                            <li><i class="fa fa-bars"></i><a href="<?= $this->siteUrl() ?>ui-tabs.html">Tabs</a></li>
                            <li><i class="fa fa-share-square-o"></i><a href="<?= $this->siteUrl() ?>ui-social-buttons.html">Social Buttons</a></li>
                            <li><i class="fa fa-id-card-o"></i><a href="<?= $this->siteUrl() ?>ui-cards.html">Cards</a></li>
                            <li><i class="fa fa-exclamation-triangle"></i><a href="<?= $this->siteUrl() ?>ui-alerts.html">Alerts</a></li>
                            <li><i class="fa fa-spinner"></i><a href="<?= $this->siteUrl() ?>ui-progressbar.html">Progress Bars</a></li>
                            <li><i class="fa fa-fire"></i><a href="<?= $this->siteUrl() ?>ui-modals.html">Modals</a></li>
                            <li><i class="fa fa-book"></i><a href="<?= $this->siteUrl() ?>ui-switches.html">Switches</a></li>
                            <li><i class="fa fa-th"></i><a href="<?= $this->siteUrl() ?>ui-grids.html">Grids</a></li>
                            <li><i class="fa fa-file-word-o"></i><a href="<?= $this->siteUrl() ?>ui-typgraphy.html">Typography</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-table"></i>Tables</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="fa fa-table"></i><a href="<?= $this->siteUrl() ?>tables-basic.html">Basic Table</a></li>
                            <li><i class="fa fa-table"></i><a href="<?= $this->siteUrl() ?>tables-data.html">Data Table</a></li>
                        </ul>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-th"></i>Forms</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-th"></i><a href="<?= $this->siteUrl() ?>forms-basic.html">Basic Form</a></li>
                            <li><i class="menu-icon fa fa-th"></i><a href="<?= $this->siteUrl() ?>forms-advanced.html">Advanced Form</a></li>
                        </ul>
                    </li>

                    <h3 class="menu-title">Icons</h3><!-- /.menu-title -->

                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-tasks"></i>Icons</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-fort-awesome"></i><a href="<?= $this->siteUrl() ?>font-fontawesome.html">Font Awesome</a></li>
                            <li><i class="menu-icon ti-themify-logo"></i><a href="<?= $this->siteUrl() ?>font-themify.html">Themefy Icons</a></li>
                        </ul>
                    </li>
                    <li>
                        <a href="<?= $this->siteUrl('viagens/listar') ?>"> <i class="menu-icon fas fa-road"></i>Viagens </a>
                        <a href="<?= $this->siteUrl('veiculos/listar') ?>"> <i class="menu-icon fas fa-bus"></i>Veículos </a>
                        <a href="<?= $this->siteUrl('empresas/listar') ?>"> <i class="menu-icon far fa-building"></i>Empresas </a>
                    </li>
                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-bar-chart"></i>Charts</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-line-chart"></i><a href="<?= $this->siteUrl() ?>charts-chartjs.html">Chart JS</a></li>
                            <li><i class="menu-icon fa fa-area-chart"></i><a href="<?= $this->siteUrl() ?>charts-flot.html">Flot Chart</a></li>
                            <li><i class="menu-icon fa fa-pie-chart"></i><a href="<?= $this->siteUrl() ?>charts-peity.html">Peity Chart</a></li>
                        </ul>
                    </li>

                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-area-chart"></i>Maps</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-map-o"></i><a href="<?= $this->siteUrl() ?>maps-gmap.html">Google Maps</a></li>
                            <li><i class="menu-icon fa fa-street-view"></i><a href="<?= $this->siteUrl() ?>maps-vector.html">Vector Maps</a></li>
                        </ul>
                    </li>
                    <h3 class="menu-title">Extras</h3><!-- /.menu-title -->
                    <li class="menu-item-has-children dropdown">
                        <a href="<?= $this->siteUrl() ?>#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="menu-icon fa fa-glass"></i>Pages</a>
                        <ul class="sub-menu children dropdown-menu">
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="<?= $this->siteUrl() ?>page-login.html">Login</a></li>
                            <li><i class="menu-icon fa fa-sign-in"></i><a href="<?= $this->siteUrl() ?>page-register.html">Register</a></li>
                            <li><i class="menu-icon fa fa-paper-plane"></i><a href="<?= $this->siteUrl() ?>pages-forget.html">Forget Pass</a></li>
                        </ul>
                    </li>
                </ul>
            </div><!-- /.navbar-collapse -->
        </nav>
    </aside><!-- /#left-panel -->
    <!-- Left Panel -->