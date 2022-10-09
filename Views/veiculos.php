<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Veículos</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="col-sm-8">
        <div class="page-header float-right">
            <div class="page-title">
                <ol class="breadcrumb text-right">
                    <li class="active">Dashboard</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">

    <div class="col-sm-12">
        <div class="alert  alert-success alert-dismissible fade show" role="alert">
            <span class="badge badge-pill badge-success">Success</span> You successfully read this important alert message.
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="layout-flex flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Veículos</h4>
                        <div class="small text-muted"><?= $veiculos->count ?> veiculos estão sendo exibidas></div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar veículo</button>
                        <?php endif ?>
                    </div>
                    <div class="">
                        <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                            <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option1"> Day
                                </label>
                                <label class="btn btn-outline-secondary active">
                                    <input type="radio" name="options" id="option2" checked=""> Month
                                </label>
                                <label class="btn btn-outline-secondary">
                                    <input type="radio" name="options" id="option3"> Year
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

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
                        <?php foreach ($veiculos->data as $veiculo) :
                        ?>
                            <tr id="linha<?= $veiculo->id ?>" class="list-label">
                                <td><span id="label_marca<?= $veiculo->id ?>"><?= $veiculo->marca ?></span></td>
                                <td><span id="label_modelo<?= $veiculo->id ?>"><?= $veiculo->modelo ?></span></td>
                                <td><span id="label_ano<?= $veiculo->id ?>"><?= $veiculo->ano ?></span></td>
                                <td><span id="label_codigo<?= $veiculo->id ?>"><?= $veiculo->codigo ?></span></td>
                                <td><span id="label_placa<?= $veiculo->id ?>" class="placas"><?= $veiculo->placa ?></span></td>
                                <td><span id="label_empresa<?= $veiculo->id ?>"><?= $veiculo->empresa ?></span></td>
                                <td><span id="label_tipo<?= $veiculo->id ?>"><?= $veiculo->tipo_nome ?> <?= $veiculo->tipo_descricao ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $veiculo->id ?>" data-empresas_id="<?= $veiculo->empresas_id ?>" data-veiculos_tipo_id="<?= $veiculo->veiculos_tipo_id ?>" data-marca="<?= $veiculo->marca ?>" data-modelo="<?= $veiculo->modelo ?>" data-ano="<?= $veiculo->ano ?>" data-codigo="<?= $veiculo->codigo ?>" data-placa="<?= $veiculo->placa ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="veiculos" data-item_id="<?= $veiculo->id ?>">
                                        <?php if (isset($veiculo->favoritos_id) && !empty($veiculo->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                </td>
                            </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>

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
                        <input type="text" class="form-elements" id="marca" name="marca" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="modelo">Modelo</label>
                        <input type="text" class="form-elements" id="modelo" name="modelo" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="ano">Ano</label>
                        <input type="text" class="form-elements" id="ano" name="ano" value="" />
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="codigo">Código</label>
                        <input type="text" class="form-elements" id="codigo" name="codigo" value="" />
                        <small class="form-text text-muted">ex. 2501</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="placa">Placa</label>
                        <input type="text" class="form-elements" id="placa" name="placa" value="" style="text-transform: uppercase;" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="empresa_id">Empresa</label>

                        <select class="form-elements" id="empresas_id" name="empresas_id">
                            <option>Selecione...</option>
                            <?php foreach ($empresas->data as $empresa) : ?>
                                <option value="<?= $empresa->id ?>"><?= $empresa->nome ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="veiculos_tipo_id">Tipo</label>

                        <select class="form-elements" id="veiculos_tipo_id" name="veiculos_tipo_id">
                            <option value="0">Selecione...</option>
                            <?php foreach ($veiculos_tipo->data as $veiculo_tipo) : ?>
                                <option value="<?= $veiculo_tipo->id ?>"><?= $veiculo_tipo->nome . " - " . $veiculo_tipo->descricao
                                                                            ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="btnExcluir" class="btn btn-outline-danger" title="Excluir"><i class="fas fa-times"></i> Excluir</button>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSalvar"><i class="fa fa-save salvar pointer"></i> Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery("#placa, .placas").mask('AAA-0A00');
    jQuery("#ano").mask('0000');


    jQuery('#veiculos_tipo_id').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements'
    });

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
        jQuery("#mediumModalLabel").html('Veículo ' + (este.data('marca') ? este.data('marca') : '') + ' ' + (este.data('modelo') ? este.data('modelo') : ''));
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
                if (retorno.status == true) {
                    jQuery("#formMediumModal").modal("hide");
                    show_message(retorno.msg, 'success', null, '/veiculos');
                    jQuery("#label_marca" + id).html(retorno.data[0].nome);
                    jQuery("#label_modelo" + id).html(retorno.data[0].descricao);
                    jQuery("#label_ano" + id).html(retorno.data[0].ano);
                    jQuery("#label_codigo" + id).html(retorno.data[0].codigo);
                    jQuery("#label_placa" + id).html(retorno.data[0].placa);
                    jQuery("#label_empresa" + id).html(retorno.data[0].empresa);
                    jQuery("#label_tipo" + id).html(retorno.data[0].tipo_descricao);
                    jQuery("#linha" + id).addClass('success-transition');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                    show_message(retorno.msg, 'danger');
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    jQuery("#btnExcluir").click(function() {
        var id = jQuery("#veiculo_id").val();
        var rota = '<?= $this->siteUrl('veiculos/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('veiculos') ?>';
        excluir(rota, 'Você realmente quer excluir este veículo?', redirect);
    });
</script>