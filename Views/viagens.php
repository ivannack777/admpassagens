<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Viagens</li>
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
<?php 
// var_dump($viagens->data); exit; 
?>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Viagens</h4>
                        <div class="small text-muted"><?= $viagens->count ?> viagens</div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar viagem</button>
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
                            <td>Descrição</td>
                            <td>Origem</td>
                            <td>Destino</td>
                            <td>Saída</td>
                            <td>Chegada</td>
                            <td>Valor</td>
                            <td>Veículo</td>
                            <td><i class="fas fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($viagens->data as $viagem) :
                        ?>
                            <tr id="linha<?= $viagem->id ?>" class="list-label">
                                <td><span id="label_descricao<?= $viagem->id ?>"><?= $viagem->descricao ?></span></td>
                                <td><span id="label_origem_id<?= $viagem->id ?>"><?= $viagem->origem_id ?> <?= $viagem->localidade_origem ?></span></td>
                                <td><span id="label_destino_id<?= $viagem->id ?>"><?= $viagem->destino_id ?> <?= $viagem->localidade_destino ?></span></td>
                                <td><span id="label_data_saida<?= $viagem->id ?>"><?= $this->dateFormat($viagem->data_saida, 'd/m/Y H:i') ?></span></td>
                                <td><span id="label_data_chegada<?= $viagem->id ?>"><?= $this->dateFormat($viagem->data_chegada, 'd/m/Y H:i') ?></span></td>
                                <td><span id="label_valor<?= $viagem->id ?>"><?= str_replace('.', ',', $viagem->valor) ?></span></td>
                                <td><span id="label_veiculos_id<?= $viagem->id ?>">
                                        <?=
                                        $viagem->marca . " " .
                                            $viagem->modelo . " " .
                                            $viagem->ano . " " .
                                            $viagem->codigo . " " .
                                            $viagem->placa
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                    <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $viagem->id ?>" data-veiculos_id="<?= $viagem->veiculos_id ?>" data-descricao="<?= $viagem->descricao ?>" 
                                            data-origem="<?= $viagem->localidade_origem ?>" 
                                            data-origem_id="<?= $viagem->origem_id ?>" 
                                            data-destino="<?= $viagem->localidade_destino ?>" 
                                            data-destino_id="<?= $viagem->destino_id ?>" 
                                            data-valor="<?= str_replace('.', ',', $viagem->valor)??'' ?>" 
                                            data-data_saida="<?= $this->dateFormat($viagem->data_saida, 'd/m/Y H:i') ?>" 
                                            data-data_chegada="<?= $this->dateFormat($viagem->data_chegada, 'd/m/Y H:i') ?>" 
                                            data-assentos="<?= $viagem->assentos ?>"
                                            data-assentos_tipo="<?= $viagem->assentos_tipo ?>"
                                            data-detalhes="<?= $viagem->detalhes ?>"
                                        >
                                        <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" 
                                    data-item="viagens" data-item_id="<?= $viagem->id ?>" 
                                        >
                                        <?php if(isset($viagem->favoritos_id) && !empty($viagem->favoritos_id)): ?>
                                            <i class="fas fa-heart"></i> 
                                        <?php else: ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" 
                                        data-item="viagens" 
                                        data-item_id="<?= $viagem->id ?>" 
                                        data-title="<?= $viagem->descricao ?>" 
                                        >
                                        <i class="far fa-comment"></i> 
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
                <h5 class="modal-title" id="mediumModalLabel">Viagem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formViagem">
                    <input type="hidden" id="viagem_id" name="viagem_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="descricao">Descrição</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="descricao" name="descricao" value="" />
                        <small class="form-text text-muted">ex. 99/99/9999</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="origem_id">Origem</label>
                        <span class="text-danger error-label"></span>
                        <input type="hidden" class="form-elements" id="origem_id" name="origem_id" value="" />
                        <input type="text" class="form-elements" id="origem" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="destino_id">Destino</label>
                        <span class="text-danger error-label"></span>
                        <input type="hidden" class="form-elements" id="destino_id" name="destino_id" value="" />
                        <input type="text" class="form-elements" id="destino" value="" />
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="data_saida">Data/hora saída</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements datas" id="data_saida" name="data_saida" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="data_chegada">Data/hora chegada</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements datas" id="data_chegada" name="data_chegada" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="valor">Valor</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements valores" id="valor" name="valor" value="" placeholder="0,00" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="assentos">Assentos</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements assentos" id="assentos" name="assentos" value="" placeholder="Quantidade de assentos" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="assentos_tipo">Tipos de assentos</label>
                        <span class="text-danger error-label"></span>
                        <select type="text" class="form-elements" id="assentos_tipo" name="assentos_tipo">
                            <option value="0">Selecione...</option>
                            <option value="Comum">Comum</option>
                            <option value="Leito">Leito</option>
                            <option value="Leito-cama">Leito-cama</option>
                            <option value="Semi-leito">Semi-leito</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="detalhes">Detalhes</label>
                        <span class="text-danger error-label"></span>
                        <textarea type="text" class="form-elements" id="detalhes" name="detalhes"></textarea>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="veiculo_id">Veículo</label>
                        <span class="text-danger error-label"></span>
                        <select class="form-elements" id="veiculos_id" name="veiculos_id">
                            <option value="0">Selecione...</option>
                            <?php foreach ($veiculos->data as $veiculo) : ?>
                                <option value="<?= $veiculo->id ?>"><?=
                                                                    $veiculo->marca . " " .
                                                                        $veiculo->modelo . " " .
                                                                        $veiculo->ano . " " .
                                                                        $veiculo->codigo . " " .
                                                                        $veiculo->placa . " "
                                                                    ?></option>
                            <?php endforeach ?>
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
    jQuery('.valores').mask("#.##0,00", {
        reverse: true
    });

    jQuery(".datas").mask('00/00/0000 00:00');
    jQuery(".assentos").mask('0#');

    jQuery(".datas").datetimepicker({
        format: "d/m/Y H:i"
    });

    jQuery('#veiculos_id').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements'
    });

    jQuery("#origem").autocomplete({
        minLength: 2,
        delay: 100,
        source: function(request, response) {
            jQuery.ajax({
                url: "/localidades",
                type: "post",
                data: {
                    nome: request.term
                },
                dataType: 'json',
                success: function(retorno) {
                    response(jQuery.map(retorno.data, function(val, key) {

                        var label = (val.localidade == val.nome_municipio ? val.localidade : val.localidade + '/' + val.nome_municipio) + ' - ' + val.sigla_uf;
                        return {
                            label: label,
                            value: label,
                            id: val.id
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            jQuery("#origem_id").val(ui.item.id)
        }
    });

    jQuery("#destino").autocomplete({
        minLength: 2,
        delay: 100,
        source: function(request, response) {
            jQuery.ajax({
                url: "/localidades",
                type: "post",
                data: {
                    nome: request.term
                },
                dataType: 'json',
                success: function(retorno) {
                    response(jQuery.map(retorno.data, function(val, key) {

                        var label = (val.localidade == val.nome_municipio ? val.localidade : val.localidade + '/' + val.nome_municipio) + ' - ' + val.sigla_uf;
                        return {
                            label: label,
                            value: label,
                            id: val.id
                        };
                    }));
                }
            });
        },
        select: function(event, ui) {
            jQuery("#destino_id").val(ui.item.id)
        }
    });


    jQuery(".editar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#viagem_id").val(este.data('id'));

        if (este.data('veiculos_id')) {
            jQuery('#veiculos_id option[value="' + este.data('veiculos_id') + '"]').prop('selected', true);
        } else {
            jQuery('#veiculos_id option[value="0"]').prop('selected', true);
        }
        if (este.data('assentos_tipo')) {
            jQuery('#assentos_tipo option[value="' + este.data('assentos_tipo') + '"]').prop('selected', true);
        } else {
            jQuery('#assentos_tipo option[value="0"]').prop('selected', true);
        }

        jQuery("#descricao").val(este.data('descricao'));
        jQuery("#origem").val(este.data('origem'));
        jQuery("#origem_id").val(este.data('origem_id'));
        jQuery("#destino").val(este.data('destino'));
        jQuery("#destino_id").val(este.data('destino_id'));
        jQuery("#data_saida").val(este.data('data_saida'));
        jQuery("#data_chegada").val(este.data('data_chegada'));
        jQuery("#valor").val(este.data('valor'));
        jQuery("#assentos").val(este.data('assentos'));
        jQuery("#assentos_tipo").val(este.data('assentos_tipo'));
        jQuery("#detalhes").val(este.data('detalhes'));

        jQuery("#mediumModalLabel").html('Viagem '+(este.data('descricao')?este.data('descricao'):''));
        
        jQuery("#formMediumModal").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#viagem_id").val();
        var form = jQuery("#formViagem");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('viagens/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                jQuery('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {
                    
                    show_message(retorno.msg, 'success', null, '/viagens');

                    let data_saida = new moment(retorno.data[0].data_saida);
                    let data_chegada = new moment(retorno.data[0].data_chegada);
                    jQuery("#label_descricao" + id).html(retorno.data[0].descricao);
                    jQuery("#label_origem_id" + id).html(retorno.data[0].origem_id);
                    jQuery("#label_destino_id" + id).html(retorno.data[0].destino_id);
                    jQuery("#label_data_saida" + id).html(data_saida.format('DD/MM/YYYY HH:mm'));
                    jQuery("#label_data_chegada" + id).html(data_chegada.format('DD/MM/YYYY HH:mm'));
                    jQuery("#label_veiculos_id" + id).html(retorno.data[0].marca + ' ' + retorno.data[0].modelo + ' ' + retorno.data[0].ano + ' ' + retorno.data[0].codigo + ' ' + retorno.data[0].placa);
                    jQuery("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
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
        var id = jQuery("#viagem_id").val();
        var rota = '<?= $this->siteUrl('viagens/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('viagens') ?>';
        excluir(rota, 'Você realmente quer excluir esta viagem?', redirect);
    });




</script>