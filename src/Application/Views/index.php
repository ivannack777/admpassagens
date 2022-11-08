<div class="conteudo">
    <div class="card text-center">
        <h2>Painel administrativo</h2>
    </div>
</div>
<?php if (isset($_SESSION['user'])) : ?>
    <div class="conteudo">
        <div class="layout-grid gap grid-4col">

            <div class="card text-white bg-flat-color-1">
                <div class="card-body pb-0">
                    <div class="dropdown float-right">
                        <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton1" data-toggle="dropdown">
                            <i class="fa fa-cog"></i>
                        </button>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                            <div class="dropdown-menu-content">
                                <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Action</a>
                                <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Another action</a>
                                <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <p class="text-light">Pedidos totais</p>
                    <h4 class="mb-0">
                        <span class="count"><?= $pedidos[0]->count ?></span>
                    </h4>

                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                        <!-- <canvas id="widgetChart1"></canvas> -->
                    </div>

                </div>

            </div>
            <!--/.col-->

            
                <div class="card text-white bg-flat-color-2">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton2" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton2">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Another action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <p class="text-light">Pedidor por mês</p>
                        <h4 class="mb-0">
                            <?php foreach ($pedidos_mes as $pMes) : ?>
                                <div><span class="count"><?= $pMes->count ?></span> <?= $this->meses($pMes->data_insert, true, true) ?></div>
                            <?php endforeach ?>
                        </h4>

                        <div class="chart-wrapper px-0" style="height:70px;" height="70">
                            <!-- <canvas id="widgetChart2"></canvas> -->
                        </div>

                    </div>
                </div>
            <!--/.col-->

                <div class="card text-white bg-flat-color-3">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton3" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton3">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Another action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <p class="text-light">Pedidor por semana</p>
                        <h4 class="mb-0">
                            <?php foreach ($pedidos_semana as $pSemana) :
                                $dataInsert = new \DateTime($pSemana->data_insert);
                            ?>
                                <div><span class="count"><?= $pSemana->count ?></span> <?= ($dataInsert->format('W')) ?></div>
                            <?php endforeach ?>
                        </h4>
                    </div>

                    <div class="chart-wrapper px-0" style="height:70px;" height="70">
                        <!-- <canvas id="widgetChart3"></canvas> -->
                    </div>
                </div>
            <!--/.col-->

                <div class="card text-white bg-flat-color-4">
                    <div class="card-body pb-0">
                        <div class="dropdown float-right">
                            <button class="btn bg-transparent dropdown-toggle theme-toggle text-light" type="button" id="dropdownMenuButton4" data-toggle="dropdown">
                                <i class="fa fa-cog"></i>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton4">
                                <div class="dropdown-menu-content">
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Another action</a>
                                    <a class="dropdown-item" href="<?= $this->siteUrl() ?>#">Something else here</a>
                                </div>
                            </div>
                        </div>
                        <p class="text-light">Total de viagens</p>
                        <h4 class="mb-0">
                            <span class="count"><?= count($viagens) ?></span>
                        </h4>

                        <div class="chart-wrapper px-3" style="height:70px;" height="70">
                            <!-- <canvas id="widgetChart4"></canvas> -->
                        </div>

                    </div>
                </div>
            <!--/.col-->
        </div>
    </div>

<?php endif ?>

</body>

</html>