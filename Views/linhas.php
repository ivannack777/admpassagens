<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Linhas</li>
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
    // var_dump($linhas->data); exit; 
    ?>

    <div class="col-xl-12">
        <div class="card">
            <div class="card-body">
                <div class="layout-flex flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Linhas</h4>
                        <div class="small text-muted"><?= $linhas->count ?> linhas</div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar linha</button>
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
                            <td>Dias</td>
                            <td><i class="fas fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($linhas->data as $linha) :
                            $dia = explode(',', $linha->dia);
                            $diaExt = [];
                            if (!empty($linha->dia)) {
                                foreach ($dia as $dia) {
                                    $diaExt[] = $this->diasSemana($dia, true);
                                }
                            }
                        ?>
                            <tr id="linha<?= $linha->id ?>" class="list-label">
                                <td><span id="label_descricao<?= $linha->id ?>"><?= $linha->descricao ?></span></td>
                                <td><span id="label_dia<?= $linha->id ?>"><?= implode(', ', $diaExt) ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $linha->id ?>" data-descricao="<?= $linha->descricao ?>" data-dia="<?= $linha->dia ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="linhas" data-item_id="<?= $linha->id ?>">
                                        <?php if (isset($linha->favoritos_id) && !empty($linha->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="linhas" data-item_id="<?= $linha->id ?>" data-title="<?= $linha->descricao ?>">
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
                    <input type="hidden" id="linhas_id" name="linhas_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="descricao">Descrição</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="descricao" name="descricao" value="" />
                        <small class="form-text text-muted">São Paulo x Rio de janeiro</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="pontos">Pontos</label>
                        <span class="text-danger error-label"></span>
                        <div id="pontosDiv" class="hide-last-last">

                        </div>

                        <button class="btn btn-secondary" id="addPontos">+</button>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="dia">Dias da semana</label>
                        <span class="text-danger error-label"></span>
                        <select type="text" class="form-elements" id="dia" name="dia[]" multiple>
                            <option value="">Selecione...</option>
                            <?php
                            $diasSemana = $this->diasSemana();
                            foreach ($diasSemana as $d => $diasSemana) : ?>
                                <option value="<?= $d ?>"><?= $diasSemana ?></option>
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
    var qtdPontos = 0;

    jQuery('#dia').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements',
        closeOnSelect: false
    });

    jQuery("#addPontos").click(function(evt) {
        evt.preventDefault();
        var c = jQuery('.pontoDiv').length
        qtdPontos++
        jQuery("#pontosDiv").append(
            ' <div class="pontoDiv layout-flex flex-row layout-dados layout-margin" style="position: relative;">' +
            '  <div><div class="circle font-20 bold6"> ' + (c + 1) + '</div></div>' +
            '  <input type="hidden" class="pontos" id="id' + (c + 1) + '" name="pontos[' + (c + 1) + '][id]" value="" />' +
            '  <input type="hidden" class="pontos" id="locais_id' + (c + 1) + '" name="pontos[' + (c + 1) + '][locais_id]" value="" />' +
            '  <div><label>Local</label><input type="text" class="form-elements cidadeAutocomplete" name="pontos[' + (c + 1) + '][cidade]" id="cidade' + (c + 1) + '" value="" data-id="' + (c + 1) + '" style="width:270px;" /></div>' +
            '  <div><label>Dias:</label><span><select class="form-elements" name="pontos[' + (c + 1) + '][dia]" id="dia' + (c + 1) + '"> <option value="">Selecione...</option>' +
            <?php $diasSemana = $this->diasSemana();
            foreach ($diasSemana as $d => $diasSemana) : ?> '<option value="<?= $d ?>"><?= $diasSemana ?></option>' +
            <?php endforeach ?> '   </select></span></div>' +
            '  <div><label>Horário:</label><span><input type="text" class="form-elements horas" name="pontos[' + (c + 1) + '][hora]" id="hora' + (c + 1) + '" value="" /></span></div>' +
            '  <div style="position: absolute; bottom: -30px; left: 18px;"><i class="fas fa-arrow-down fa-2x" style="color: #408ba9"></div>' +
            '</div>'
        );
        jQuery(".horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        jQuery(".valores").mask('#.##0,00', {
            reverse: true
        });
        jQuery(".horas").mask('00:00', {
            reverse: true
        });

        jQuery(".cidadeAutocomplete").autocomplete({
            minLength: 2,
            delay: 100,
            source: function(request, response) {

                jQuery.ajax({
                    url: "/locais/listar",
                    type: "post",
                    data: {
                        cidade: request.term
                    },
                    dataType: 'json',
                    success: function(retorno) {
                        response(jQuery.map(retorno.data, function(val, key) {

                            var label = val.cidade + ' - ' + val.uf + ' / ' + val.endereco;
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
                console.log(event)
                let id = jQuery(event.target).data('id');
                console.log(jQuery(event.target).data('id'), id)
                jQuery("#locais_id" + id).val(ui.item.id)
            }
        });
    });



    jQuery(".editar").click(function() {
        qtdPontos = jQuery("#pontosDiv").find('.pontos');
        qtdPontos = qtdPontos.length;
        var este = jQuery(this);
        var id = este.data('id');


        // if (este.data('dia')) {
        //     console.log(este.data('dia').split(','))
        //     jQuery('#dia option[value="' + este.data('dia').split(',') + '"]').prop('selected', true);
        // } else {
        //     jQuery('#dia option[value="0"]').prop('selected', true);
        // }

        jQuery("#linhas_id").val(este.data('id'));
        jQuery("#descricao").val(este.data('descricao'));
        jQuery("#valor").val(este.data('valor'));
        jQuery("#assentos").val(este.data('assentos'));
        jQuery("#dia").val(este.data('dia')?.split(',')).trigger('change');

        jQuery("#pontosDiv").html('');
        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('linhas/pontos') ?>',
            data: {
                linhas_id: id
            },
            dataType: 'json',
            beforeSend: function() {
                jQuery("#pontosDiv").html('Aguarde...');
            },
            success: function(retorno) {
                if (retorno.status == true) {
                    jQuery("#pontosDiv").html('');
                    if (retorno.data.length) {
                        let diasSemana = <?= json_encode($this->diasSemana()) ?>;
                        jQuery.each(retorno.data, function(c, ponto) {
                            jQuery("#pontosDiv").append(
                                ' <div class="pontoDiv layout-flex flex-row layout-dados layout-margin" style="position: relative;">' +
                                '  <div><div class="circle font-20 bold6"> ' + (c + 1) + '</div></div>' +
                                '  <input type="hidden" id="id' + (c + 1) + '" name="pontos[' + (c + 1) + '][id]" value="' + ponto.id + '" />' +
                                '  <input type="hidden" id="locais_id' + (c + 1) + '" name="pontos[' + (c + 1) + '][locais_id]" value="' + ponto.locais_id + '" />' +
                                '  <div><label>Local</label><input type="text" class="form-elements cidadeAutocomplete" name="pontos[' + (c + 1) + '][cidade]" id="cidade" value="' + ponto.cidade + ' - ' + ponto.uf + '" /></div>' +
                                '  <div><label>Dia da semana:</label><span><select class="form-elements" name="pontos[' + (c + 1) + '][dia]" id="dia' + (c + 1) + '"> <option value="">Selecione...</option></select></div>' +
                                '  <div><label>Horário:</label><span> <input type="text" class="form-elements horas" name="pontos[' + (c + 1) + '][hora]" id="hora' + (c + 1) + '" value="' + ponto.hora + '" /></span></div>' +
                                '  <div style="position: absolute; bottom: -30px; left: 18px;"><i class="fas fa-arrow-down fa-2x" style="color: #408ba9"></div>' +
                                '</div>'
                            );
                            for(let w in diasSemana){
                                if(w == ponto.dia){
                                    newOption = new Option(diasSemana[w], w, true, true);
                                } else {
                                    newOption = new Option(diasSemana[w], w, false, false);
                                }
                                $("#dia" + (c + 1)).append(newOption);
                            }
                            
                        });
                    } else {
                        jQuery("#pontosDiv").append(retorno.msg);
                    }

                    jQuery(".valores").mask('#.##0,00', {
                        reverse: true
                    });
                    jQuery(".horas").mask('00:00', {
                        reverse: true
                    });


                } else {

                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            },
            complete: function() {
                jQuery(".horas").datetimepicker({
                    format: "HH:mm",
                });

                jQuery(".valores").mask('#.##0,00', {
                    reverse: true
                });

                jQuery(".cidadeAutocomplete").autocomplete({
                    minLength: 2,
                    delay: 100,
                    source: function(request, response) {

                        jQuery.ajax({
                            url: "/locais",
                            type: "post",
                            data: {
                                cidade: request.term
                            },
                            dataType: 'json',
                            success: function(retorno) {
                                response(jQuery.map(retorno.data, function(val, key) {

                                    var label = val.cidade + ' - ' + val.uf;
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
                        console.log(event)
                        let id = jQuery(event.target).data('id');
                        console.log(jQuery(event.target).data('id'), id)
                        jQuery("#locais_id" + id).val(ui.item.id)
                    }
                });

            }
        });



        jQuery("#mediumModalLabel").html('Viagem ' + (este.data('descricao') ? este.data('descricao') : ''));

        jQuery("#formMediumModal").modal("show")
    });


    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#linhas_id").val();
        var form = jQuery("#formViagem");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('linhas/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                jQuery('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {

                    show_message(retorno.msg, 'success', null, '/linhas');

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
        var id = jQuery("#linhas_id").val();
        var rota = '<?= $this->siteUrl('linhas/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('linhas') ?>';
        excluir(rota, 'Você realmente quer excluir esta linha?', redirect);
    });
</script>