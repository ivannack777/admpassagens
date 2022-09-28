<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Pedidos</li>
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
                <div class="flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Pedidos</h4>
                        <div class="small text-muted"><?= $pedidos->count() ?> pedidos estão sendo exibidas</div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar pedido</button>
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
                            <td>Código</td>
                            <td>Cliente</td>
                            <td>Viagem</td>
                            <td>CPF</td>
                            <td>Valor</td>
                            <td>Status</td>
                            <td>Data/Hora</td>
                            <td><i class="fas fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($pedidos as $pedido) :
                        ?>
                            <tr id="linha<?= $pedido->id ?>" class="list-label">
                                <td><span id="label_codigo<?= $pedido->id ?>"><?= $pedido->codigo ?></span></td>
                                <td><span id="label_cliente_nome<?= $pedido->id ?>"><?= $pedido->cliente_nome ?></span></td>
                                <td><span id="label_viagem_descricao<?= $pedido->id ?>"><?= $pedido->viagem_descricao ?></span></td>
                                <td><span id="label_cpf<?= $pedido->id ?>" class="label_cpf"><?= $pedido->cpf ?></span></td>
                                <td><span id="label_valor<?= $pedido->id ?>"><?= str_replace('.', ',', $pedido->valor) ?></span></td>
                                <td><span id="label_status<?= $pedido->id ?>"><?= $pedido->status ?></span></td>
                                <td><span id="label_data<?= $pedido->id ?>"><?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $pedido->id ?>" data-codigo="<?= $pedido->codigo ?>" data-clientes_id="<?= $pedido->clientes_id ?>" data-viagens_id="<?= $pedido->viagens_id ?>" data-cpf="<?= $pedido->cpf ?>" data-valor="<?= str_replace('.', ',', $pedido->valor) ?>" data-status="<?= $pedido->status ?>" data-data_insert="<?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
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
                <h5 class="modal-title" id="mediumModalLabel">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formViagem">
                    <input type="hidden" id="pedidos_id" name="pedidos_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="clientes_id">Cliente</label>
                        <span class="text-danger error-label"></span>
                        <select class="form-elements" id="clientes_id" name="clientes_id">
                            <option value="0">Selecione...</option>
                            <?php foreach ($clientes as $cliente) : ?>
                                <option value="<?= $cliente->id ?>"><?= $cliente->nome ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="viagens_id">Viagem</label>
                        <span class="text-danger error-label"></span>

                        <select class="form-elements" id="viagens_id" name="viagens_id">
                            <option value="0">Selecione...</option>
                            <?php foreach ($viagens as $viagem) : ?>
                                <option value="<?= $viagem->id ?>"><?= $viagem->descricao ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="cpf">CPF</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="cpf" name="cpf" value="" placeholder="___.___.___-__" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="valor">Valor</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="valor" name="valor" value="" placeholder="0,00" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="status">Status</label>
                        <span class="text-danger error-label"></span>
                        <select type="text" class="form-elements" id="status" name="status">
                            <option value="0">Selecione...</option>
                            <option value="R">Reservado</option>
                            <option value="P">Pago</option>
                            <option value="C">Cancelado</option>
                        </select>
                    </div>
                </form>
                <div id="retornomsg"></div>
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
    jQuery('#valor').mask("#.##0,00", {
        reverse: true
    });
    jQuery('.label_cpf').mask("000.000.000-00");

    jQuery(".datas").mask('00/00/0000 00:00');

    jQuery(".datas").datetimepicker({
        format: "d/m/Y H:i"
    });

    jQuery('#veiculos_id').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements'
    });

    jQuery(".editar").click(function() {
        var este = jQuery(this);

        var id = jQuery("#pedidos_id").val(este.data('id'));

        if (este.data('clientes_id')) {
            jQuery('#clientes_id option[value="' + este.data('clientes_id') + '"]').prop('selected', true);
        } else {
            jQuery('#clientes_id option[value="0"]').prop('selected', true);
        }
        if (este.data('viagens_id')) {
            jQuery('#viagens_id option[value="' + este.data('viagens_id') + '"]').prop('selected', true);
        } else {
            jQuery('#viagens_id option[value="0"]').prop('selected', true);
        }

        if (este.data('status')) {
            jQuery('#status option[value="' + este.data('status') + '"]').prop('selected', true);
        } else {
            jQuery('#status option[value="0"]').prop('selected', true);
        }

        jQuery("#clientes_id").val(este.data('clientes_id'));
        jQuery("#viagens_id").val(este.data('viagens_id'));
        jQuery("#cpf").val(este.data('cpf')).mask("000.000.000-00");
        jQuery("#valor").val(este.data('valor')?.replace('.', ',')).mask("#.##0,00", {
            reverse: true
        });
        jQuery("#status").val(este.data('status'));
        jQuery("#mediumModalLabel").html('Pedido '+(este.data('codigo')?este.data('codigo'):''));

        jQuery("#formMediumModal").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#pedidos_id").val();
        var form = jQuery("#formViagem");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('pedidos/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                jQuery('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {
                    jQuery("#formMediumModal").modal("hide");
                    show_message(retorno.msg, 'success');

                    let data = new moment(retorno.data[0].dataInsret);

                    jQuery("#label_codigo" + id).html(retorno.data[0].descricao);
                    jQuery("#label_cliente_nome" + id).html(retorno.data[0].cliente_nome);
                    jQuery("#label_viagem_descricao" + id).html(retorno.data[0].viagem_descricao);
                    jQuery("#label_cpf" + id).html(data.cpf).mask('000.000.000-00');
                    jQuery("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
                    jQuery("#label_status" + id).html(retorno.data[0].status);
                    jQuery("#linha" + id).addClass('success-transition');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                    // jQuery("#retornomsg").html(retorno.msg).removeClass().addClass('text-danger');
                    if (retorno.data) {
                        for (var key in retorno.data) {
                            jQuery("#" + key).parent('div').find('.error-label').html(retorno.data[key]);
                        }

                    }
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    jQuery("#btnExcluir").click(function() {
        var id = jQuery("#pedidos_id").val();
        var rota = '<?= $this->siteUrl('pedidos/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('pedidos') ?>';
        excluir(rota, 'Você realmente quer excluir este pedido?', redirect);
    });
</script>