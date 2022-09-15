<div class="content mt-3">

    <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert message.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>


    <div class="col-sm-6 col-lg-3">
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
                <h4 class="mb-0">
                    <span class="count">10468</span>
                </h4>
                <p class="text-light">Members online</p>

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    <canvas id="widgetChart1"></canvas>
                </div>

            </div>

        </div>
    </div>
    <!--/.col-->

    <div class="col-sm-6 col-lg-3">
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
                <h4 class="mb-0">
                    <span class="count">10468</span>
                </h4>
                <p class="text-light">Members online</p>

                <div class="chart-wrapper px-0" style="height:70px;" height="70">
                    <canvas id="widgetChart2"></canvas>
                </div>

            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-sm-6 col-lg-3">
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
                <h4 class="mb-0">
                    <span class="count">10468</span>
                </h4>
                <p class="text-light">Members online</p>

            </div>

            <div class="chart-wrapper px-0" style="height:70px;" height="70">
                <canvas id="widgetChart3"></canvas>
            </div>
        </div>
    </div>
    <!--/.col-->

    <div class="col-sm-6 col-lg-3">
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
                <h4 class="mb-0">
                    <span class="count">10468</span>
                </h4>
                <p class="text-light">Members online</p>

                <div class="chart-wrapper px-3" style="height:70px;" height="70">
                    <canvas id="widgetChart4"></canvas>
                </div>

            </div>
        </div>
    </div>
    <!--/.col-->


    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-4">
                        <h4 class="card-title mb-0">Veículos</h4>
                        <div class="small text-muted"><?= $veiculos->count() ?> veiculos estão sendo exibidas></div>
                    </div>
                    <!--/.col-->
                    <div class="col-sm-8 hidden-sm-down">
                        <button type="button" class="btn btn-primary float-right bg-flat-color-1"><i class="fa fa-cloud-download"></i></button>
                        <div class="btn-toolbar float-right" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
                                <label class="control-label mb-1" class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option1"> Day
                                </label>
                                <label class="control-label mb-1" class="btn btn-outline-secondary active">
                                    <input type="radio" name="options" id="option2" checked=""> Month
                                </label>
                                <label class="control-label mb-1" class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option3"> Year
                                </label>
                            </div>
                        </div>
                    </div>
                    <!--/.col-->

                    <table id="bootstrap-data-table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="bootstrap-data-table_info">
                        <thead>
                            <tr>
                                <td>Marca</td>
                                <td>Modelo</td>
                                <td>Ano</td>
                                <td>Codigo</td>
                                <td>Placa</td>
                                <td>Empresa</td>
                                <td>Tipo</td>
                                <td><i class="fas fa-cog"></i></td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($veiculos as $veiculo) :
                            ?>
                                <tr id="linha<?= $veiculo->id ?>" class="list-label">
                                    <td><span id="label_marca<?= $veiculo->id ?>"><?= $veiculo->marca ?></span></td>
                                    <td><span id="label_modelo<?= $veiculo->id ?>"><?= $veiculo->modelo ?></span></td>
                                    <td><span id="label_ano<?= $veiculo->id ?>"><?= $veiculo->ano ?></span></td>
                                    <td><span id="label_codigo<?= $veiculo->id ?>"><?= $veiculo->codigo ?></span></td>
                                    <td><span id="label_placa<?= $veiculo->id ?>"><?= $veiculo->placa ?></span></td>
                                    <td><span id="label_empresa<?= $veiculo->id ?>"><?= $veiculo->empresa ?></span></td>
                                    <td><span id="label_tipo<?= $veiculo->id ?>"><?= $veiculo->tipo_nome ?> <?= $veiculo->tipo_descricao ?></span></td>
                                    <td>
                                        <i class="far fa-edit editar pointer text-info" data-id="<?= $veiculo->id ?>" data-empresas_id="<?= $veiculo->empresas_id ?>" data-veiculos_tipo_id="<?= $veiculo->veiculos_tipo_id ?>" data-marca="<?= $veiculo->marca ?>" data-modelo="<?= $veiculo->modelo ?>" data-ano="<?= $veiculo->ano ?>" data-codigo="<?= $veiculo->codigo ?>" data-placa="<?= $veiculo->placa ?>">
                                        </i>
                                        <i class="fas fa-times excluir pointer text-danger" data-id="<?= $veiculo->id ?>"></i>
                                    </td>
                                </tr>

                            <?php endforeach ?>
                        </tbody>
                    </table>



                    <div class="modal fade" id="formMediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="mediumModalLabel">Veículo</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="formveiculo">
                                        <input type="hidden" id="veiculo_id" name="veiculo_id" value="" />

                                        <div class="form-group">
                                            <label class="control-label mb-1" for="marca">Marca</label>
                                            <input type="text" class="form-control" id="marca" name="marca" value="" />
                                            <small class="form-text text-muted">ex. 99/99/9999</small>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1" for="modelo">modelo</label>
                                            <input type="text" class="form-control" id="modelo" name="modelo" value="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1" for="ano">ano</label>

                                            <input type="text" class="form-control" id="ano" name="ano" value="" />
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1" for="codigo">Data/hora saída</label>
                                            <input type="text" class="form-control" id="codigo" name="codigo" value="" />
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label mb-1" for="placa">placa</label>
                                            <input type="text" class="form-control" id="placa" name="placa" value="" />
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1" for="empresa_id">Empresa</label>

                                            <select class="form-control" id="empresas_id" name="empresas_id">
                                                <option>Selecione...</option>
                                                <?php foreach ($empresas as $empresa) : ?>
                                                    <option value="<?= $empresa->id ?>"><?= $empresa->nome ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="control-label mb-1" for="veiculos_tipo_id">Tipo</label>

                                            <select class="form-control" id="veiculos_tipo_id" name="veiculos_tipo_id">
                                                <option>Selecione...</option>
                                                <?php foreach ($veiculos_tipo as $veiculo_tipo) : ?>
                                                    <option value="<?= $veiculo_tipo->id ?>"><?= $veiculo_tipo->nome . " - " . $veiculo_tipo->descricao
                                                                                                ?></option>
                                                <?php endforeach ?>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-primary" id="btnSalvar"><i class="fa fa-save salvar pointer"></i> Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <!--/.row-->


            </div>
            <div class="card-footer">
                <ul>
                    <li>
                        <div class="text-muted">Visits</div>
                        <strong>29.703 Users (40%)</strong>
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-success" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                    <li class="hidden-sm-down">
                        <div class="text-muted">Unique</div>
                        <strong>24.093 Users (20%)</strong>
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                    <li>
                        <div class="text-muted">Pageviews</div>
                        <strong>78.706 Views (60%)</strong>
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                    <li class="hidden-sm-down">
                        <div class="text-muted">New Users</div>
                        <strong>22.123 Users (80%)</strong>
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar bg-danger" role="progressbar" style="width: 80%;" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                    <li class="hidden-sm-down">
                        <div class="text-muted">Bounce Rate</div>
                        <strong>40.15%</strong>
                        <div class="progress progress-xs mt-2" style="height: 5px;">
                            <div class="progress-bar" role="progressbar" style="width: 40%;" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- .content -->



<script>
    jQuery(".editar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#veiculo_id").val(este.data('id'));

        jQuery('#empresas_id option[value="' + este.data('empresas_id') + '"]').prop('selected', true);
        jQuery('#veiculos_tipo_id option[value="' + este.data('veiculos_tipo_id') + '"]').prop('selected', true);
        jQuery("#marca").val(este.data('marca'));
        jQuery("#modelo").val(este.data('modelo'));
        jQuery("#ano").val(este.data('ano'));
        jQuery("#codigo").val(este.data('codigo'));
        jQuery("#placa").val(este.data('placa'));

        jQuery("#formMediumModal").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var id = jQuery("#veiculo_id").val();
        var form = jQuery("#formveiculo");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('veiculos/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(retorno) {
                jQuery("#formMediumModal").modal("hide")
                if (retorno.status == true) {
                    jQuery("#label_marca" + id).html(retorno.data.nome);
                    jQuery("#label_modelo" + id).html(retorno.data.descricao);
                    jQuery("#label_ano" + id).html(retorno.data.ano);
                    jQuery("#label_codigo" + id).html(retorno.data.codigo);
                    jQuery("#label_placa" + id).html(retorno.data.placa);
                    jQuery("#label_empresa" + id).html(retorno.data.empresas_id);
                    jQuery("#label_tipo" + id).html(retorno.data.veiculos_tipo_id);
                    jQuery("#linha" + id).addClass('success-transition');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });
</script>