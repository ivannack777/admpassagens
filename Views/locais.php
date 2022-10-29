<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Locais</li>
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
    // var_dump($locais->data); exit; 
    ?>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="layout-flex flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Locais</h4>
                        <div class="small text-muted"><?= $locais->count ?> locais</div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar local</button>
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
                            <th>Cidade</th>
                            <th>Sigla</th>
                            <th>Estado</th>
                            <th>Endereço</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($locais->data as $local): ?>
                            <tr id="local<?= $local->id ?>" class="list-label">
                                <td><span id="label_cidade<?= $local->id ?>"><?= $local->cidade ?></span></td>
                                <td><span id="label_sigla<?= $local->id ?>"><?= $local->sigla ?> </span></td>
                                <td><span id="label_uf<?= $local->id ?>"><?= $local->uf ?> <?= $local->uf_nome ?></span></td>
                                <td><span id="label_endereco<?= $local->id ?>"><?= $local->endereco ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" 
                                        data-id="<?= $local->id ?>" data-cidade="<?= $local->cidade ?>" data-uf="<?= $local->uf ?>" data-endereco="<?= $local->endereco ?>" >
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="locais" data-item_id="<?= $local->id ?>">
                                        <?php if (isset($local->favoritos_id) && !empty($local->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="locais" data-item_id="<?= $local->id ?>" data-title="<?= $local->cidade ?>">
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
                    <input type="hidden" id="locais_id" name="locais_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="cidade">Cidade</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements" id="cidade" name="cidade" value="" />
                        <small class="form-text text-muted">Ex: São Paulo x Rio de janeiro</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="sigla">Sigla</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements" id="sigla" name="sigla" value="" placeholder="Sigla da cidade"/>
                        <small class="form-text text-muted">Ex: SPO</small>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="uf">Estado</label>
                        <span class="error-label"></span>

                        <select type="text" class="form-elements" id="uf" name="uf">
                            <option value="0">Selecione...</option>
                            <?php  foreach($estados->data as $estado): ?>
                                <option value="<?= $estado->sigla ?>"><?= $estado->nome ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="endereco">Endereço</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements" id="endereco" name="endereco" value="" />
                        <small class="form-text text-muted">Ex: Terminal Rodoviário - Rua das Esmeraldas...</small>
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
    var qtdPontos = 0;

    jQuery('#uf').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements',
        closeOnSelect: false
    });




    jQuery(".editar").click(function() {
        qtdPontos = jQuery("#pontosDiv").find('.pontos');
        qtdPontos = qtdPontos.length;
        var este = jQuery(this);
        var id = este.data('id');


        // if (este.data('uf')) {
        //     console.log(este.data('uf').split(','))
        //     jQuery('#uf option[value="' + este.data('uf').split(',') + '"]').prop('selected', true);
        // } else {
        //     jQuery('#uf option[value="0"]').prop('selected', true);
        // }

        jQuery("#locais_id").val(este.data('id'));
        jQuery("#cidade").val(este.data('cidade'));
        jQuery("#uf").val(este.data('uf')).trigger('change');
        jQuery("#sigla").val(este.data('sigla'));
        jQuery("#endereco").val(este.data('endereco'));

        jQuery("#mediumModalLabel").html('Viagem ' + (este.data('cidade') ? este.data('cidade') : ''));

        jQuery("#formMediumModal").modal("show")
    });


    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#locais_id").val();
        var form = jQuery("#formViagem");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('locais/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                jQuery('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {

                    show_message(retorno.msg, 'success', null, '/locais');

                    let data_saida = new moment(retorno.data[0].data_saida);
                    let data_chegada = new moment(retorno.data[0].data_chegada);
                    jQuery("#label_cidade" + id).html(retorno.data[0].cidade);
                    jQuery("#label_origem_id" + id).html(retorno.data[0].origem_id);
                    jQuery("#label_destino_id" + id).html(retorno.data[0].destino_id);
                    jQuery("#label_data_saida" + id).html(data_saida.format('DD/MM/YYYY HH:mm'));
                    jQuery("#label_data_chegada" + id).html(data_chegada.format('DD/MM/YYYY HH:mm'));
                    jQuery("#label_veiculos_id" + id).html(retorno.data[0].marca + ' ' + retorno.data[0].modelo + ' ' + retorno.data[0].ano + ' ' + retorno.data[0].codigo + ' ' + retorno.data[0].placa);
                    jQuery("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
                    jQuery("#local" + id).addClass('success-transition');
                } else {
                    jQuery("#local" + id).addClass('error-transition');
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
        var id = jQuery("#locais_id").val();
        var rota = '<?= $this->siteUrl('locais/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('locais') ?>';
        excluir(rota, 'Você realmente quer excluir esta local?', redirect);
    });
</script>