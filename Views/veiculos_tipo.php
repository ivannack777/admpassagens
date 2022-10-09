<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Tipos de veículos</li>
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
                        <h4 class="card-title mb-0">Tipos de veículos</h4>
                        <div class="small text-muted"><?= $veiculosTipo->count ?> tipos de veículos estão sendo exibidos></div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar tipo de veículo</button>
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
                            <td>Nome</td>
                            <td>Descrição</td>
                            <td><i class="fas fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach ($veiculosTipo->data as $tipo) :
                        ?>
                            <tr id="linha<?= $tipo->id ?>" class="list-label">
                                <td><span id="label_nome<?= $tipo->id ?>"><?= $tipo->nome ?></span></td>
                                <td><span id="label_descricao<?= $tipo->id ?>"><?= $tipo->descricao ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $tipo->id ?>" data-nome="<?= $tipo->nome ?>" data-descricao="<?= $tipo->descricao ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="veiculos_tipo" data-item_id="<?= $tipo->id ?>">
                                        <?php if (isset($tipo->favoritos_id) && !empty($tipo->favoritos_id)) : ?>
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
                <h5 class="modal-title" id="mediumModalLabel">Tipo de veículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formtipo">
                    <input type="hidden" id="tipo_id" name="tipo_id" value="" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="nome">Nome</label>
                        <input type="text" class="form-elements" id="nome" name="nome" value="" />
                        <small class="form-text text-muted">Ex: Ônibus</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="descricao">Descrição</label>
                        <input type="text" class="form-elements" id="descricao" name="descricao" value="" />
                        <small class="form-text text-muted">Ex: Veículo de transmporte de passageiros</small>
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
    jQuery(".editar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#tipo_id").val(este.data('id'));
        jQuery("#nome").val(este.data('nome'));
        jQuery("#descricao").val(este.data('descricao'));
        jQuery("#mediumModalLabel").html('Tipo de veículo ' + (este.data('nome') ? este.data('nome') : ''));
        jQuery("#formMediumModal").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var id = jQuery("#tipo_id").val();
        var form = jQuery("#formtipo");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('veiculos/tipo/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(retorno) {
                if (retorno.status == true) {
                    jQuery("#formMediumModal").modal("hide");
                    show_message(retorno.msg, 'success');

                    jQuery("#label_nome" + id).html(retorno.data.nome);
                    jQuery("#label_descricao" + id).html(retorno.data.descricao);
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

    jQuery("#btnExcluir").click(function() {
        var id = jQuery("#tipo_id").val();
        var rota = '<?= $this->siteUrl('veiculos/tipo/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('veiculos/tipo') ?>';
        excluir(rota, 'Você realmente quer excluir este tipo de veículo?', redirect);
    });
</script>