<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Trechos</li>
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
                        <h4 class="card-title mb-0">Trechos</h4>
                        <div class="small text-muted"><?= $trechos->msg ?></div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button id="adicionar" type="button" class="btn btn-primary bg-flat-color-1"><i class="fas fa-plus"></i> Adicionar trecho</button>
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
                <?php
                // var_dump($trechos); 
                ?>

                <table id="bootstrap-data-table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="bootstrap-data-table_info">
                    <thead>
                        <tr>
                            <td>Linha</td>
                            <td>Local origem</td>
                            <td>Local destino</td>
                            <td>Horário</td>
                            <td>Valor</td>
                            <td><i class="fas fa-cog"></i></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trechos->data as $trecho) :

                        ?>
                            <tr id="trecho<?= $trecho->id ?>" class="list-label">
                                <td><span id="label_linha<?= $trecho->id ?>"><?= $trecho->linhas_descricao ?></span></td>
                                <td><span id="label_origem_id<?= $trecho->id ?>"><a href="<?= $this->siteUrl('trechos?origem_key=' . $trecho->origem_key) ?>"> <?= $trecho->origem_cidade ?> - <?= $trecho->origem_uf ?></a></span></td>
                                <td><span id="label_destino_id<?= $trecho->id ?>"><a href="<?= $this->siteUrl('trechos?destino_key=' . $trecho->destino_key) ?>"> <?= $trecho->destino_cidade ?> - <?= $trecho->destino_uf ?></a></span></td>
                                <td><span id="label_hora_id<?= $trecho->id ?>" class="horas"><?= $trecho->hora ?></span></td>
                                <td><span id="label_valor_id<?= $trecho->id ?>" class="valores"><?= $trecho->valor ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $trecho->id ?>" data-linhas_id="<?= $trecho->linhas_id ?>" data-linhas_descricao="<?= $trecho->linhas_descricao ?>" data-origem_id="<?= $trecho->origem_id ?>" data-origem="<?= $trecho->origem_cidade ?> - <?= $trecho->origem_uf ?>/ <?= $trecho->origem_endereco ?>" data-destino_id="<?= $trecho->destino_id ?>" data-destino="<?= $trecho->destino_cidade ?> - <?= $trecho->destino_uf ?>/ <?= $trecho->destino_endereco ?>" data-hora="<?= $trecho->hora ?>" data-valor="<?= $trecho->valor ?>" data-dia="<?= $trecho->dia ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="trechos" data-item_id="<?= $trecho->id ?>">
                                        <?php if (isset($trecho->favoritos_id) && !empty($trecho->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="trechos" data-item_id="<?= $trecho->id ?>" data-title="<?= $trecho->linhas_descricao ?>">
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
                <h5 class="modal-title" id="mediumModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTrecho">
                    <input type="hidden" id="trechos_id" name="trechos_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="linha">Linha</label>
                        <span class="text-danger error-label"></span>
                        <select type="text" class="form-elements" id="linhas_id" name="linhas_id">
                            <option value="">Selecione...</option>
                            <?php
                            foreach ($linhas->data as $linha) : ?>
                                <option value="<?= $linha->id ?>"><?= $linha->descricao ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="origem_id">Local de origem</label>
                        <span class="text-danger error-label"></span>
                        <input type="hidden" id="origem_id" name="origem_id" />
                        <!--deixar sem name pra não fazer submit -->
                        <input type="text" class="form-elements cidadeAutocomplete" id="origem" data-target="origem_id" />
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="destino_id">Local de destino</label>
                        <span class="text-danger error-label"></span>
                        <input type="hidden" id="destino_id" name="destino_id" />
                        <!--deixar sem name pra não fazer submit -->
                        <input type="text" class="form-elements cidadeAutocomplete" id="destino" data-target="destino_id" />
                    </div>

                    <div class="layout-flex">
                        <div class="form-group">
                            <label class="control-label mb-1" for="hora">Horário</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="hora" name="hora" style="width: 150px;" />
                        </div>

                        <div class="form-group">
                            <label class="control-label mb-1" for="valor">Valor</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="valor" style="width: 150px;" />
                        </div>
                    </div>


                    <div class="form-group">
                        <label class="control-label mb-1" for="dia">Dias da semana</label>
                        <span class="text-danger error-label"></span>
                        <select type="text" class="form-elements" id="dia" name="dia" style="width: 150px;">
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
    jQuery(".valores").mask('#.##0,00', {
        reverse: true
    });
    jQuery(".horas").mask('00:00', {
        reverse: true
    });

    var qtdPontos = 0;

    $('#dia').select2({
        dropdownParent: $('#formMediumModal'),
        class: 'form-elements',
        closeOnSelect: false
    });

    $("#addPontos").click(function(evt) {
        evt.preventDefault();
        var c = $('.pontoDiv').length + 1;
        qtdPontos++
        $("#pontosDiv").append(
            ' <div class="pontoDiv layout-flex flex-row layout-dados layout-margin" style="position: relative;">' +
            '  <div><i class="fas fa-level-up-alt fa-2x fa-fw fa-rotate-90" style="color: #408ba9"></i></div>' +
            '  <input type="text" class="pontos" id="destino_id' + c + '" name="pontos[' + c + '][destino_id]" value="" />' +
            '  <div><label>Destino</label><input type="text" class="form-elements cidadeAutocomplete" id="destino' + c + '" value="" data-id="' + c + '" data-target="destino_id' + c + '" style="width:270px;" /></div>' + //deixar sem name pra não fazer submit
            '  <div><label>Dia:</label>' +
            '    <select class="form-elements" name="pontos[' + c + '][dia]" id="dia' + c + '"> <option value="">Selecione...</option>' +
            '<?php $diasSemana = $this->diasSemana();
                foreach ($diasSemana as $d => $diasSemana) : ?> <option value="<?= $d ?>"><?= $diasSemana ?></option><?php endforeach ?>' +
            '    </select>' +
            '  </div>' +
            '  <div><label>Horário:</label><input type="text" class="form-elements horas" name="pontos[' + c + '][hora]" id="hora' + c + '" value="" /></div>' +
            '  <div><label>Valor:</label><input type="text" class="form-elements valores" name="pontos[' + c + '][valor]" id="valor' + c + '" value="" /></div>' +
            '</div>'
        );
        $(".horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        $(".valores").mask('#.##0,00', {
            reverse: true
        });
        $(".horas").mask('00:00', {
            reverse: true
        });


    });

    $("body").on('keyup', '.cidadeAutocomplete', function(evt) {

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90)) {
            console.log(".cidadeAutocomplete", evt.keyCode)
            autocompleteLocais($(this));
        }
    })

    $("#adicionar").click(function() {
        $("#mediumModalLabel").html("Adicionar um novo trecho");
        $("#formTrecho")[0].reset();
        $("#formMediumModal").modal("show")
    });

    $(".editar").click(function() {
        qtdPontos = $("#pontosDiv").find('.pontos');
        qtdPontos = qtdPontos.length;
        var este = $(this);
        var id = este.data('id');


        // if (este.data('dia')) {
        //     console.log(este.data('dia').split(','))
        //     $('#dia option[value="' + este.data('dia').split(',') + '"]').prop('selected', true);
        // } else {
        //     $('#dia option[value="0"]').prop('selected', true);
        // }

        $("#trechos_id").val(este.data('id'));
        $("#linha").val(este.data('linha'));
        $("#linhas_id").select2().val(este.data('linhas_id')).trigger('change');
        $("#linha").val(este.data('linha'));
        $("#origem_id").val(este.data('origem_id'));
        $("#origem").val(este.data('origem'));
        $("#destino_id").val(este.data('destino_id'));
        $("#destino").val(este.data('destino'));
        $("#hora").val(este.data('hora'));
        $("#valor").val(este.data('valor'));
        $("#dia").select2().val(este.data('dia')).trigger('change');

        // $("#pontosDiv").html('');
        // $.ajax({
        //     type: 'POST',
        //     url: '<?= $this->siteUrl('trechos/pontos') ?>',
        //     data: {
        //         trechos_id: id
        //     },
        //     dataType: 'json',
        //     beforeSend: function() {
        //         $("#pontosDiv").html('Aguarde...');
        //     },
        //     success: function(retorno) {
        //         if (retorno.status == true) {
        //             $("#pontosDiv").html('');
        //             if (retorno.data.length) {
        //                 let diasSemana = <?= json_encode($this->diasSemana()) ?>;
        //                 $.each(retorno.data, function(c, ponto) {
        //                     n = c + 1;
        //                     $("#pontosDiv").append(
        //                         ' <div class="pontoDiv layout-flex flex-row layout-dados layout-margin" style="position: relative;">' +
        //                         '  <div><i class="fas fa-level-up-alt fa-2x fa-fw fa-rotate-90" style="color: #408ba9"></i></div>' +
        //                         '  <input type="text" class="pontos" id="destino_id' + n + '" name="pontos[' + n + '][destino_id]" value="'+ ponto.destino_id +'" />' +
        //                         '  <div><label>Destino</label><input type="text" class="form-elements cidadeAutocomplete" id="destino' + n + '" value="'+ ponto.destino_cidade +' - '+ ponto.destino_uf +'/'+ ponto.destino_endereco +'" data-id="'+ c +'" data-target="destino_id' + n + '" style="width:270px;" /></div>' + //deixar sem name pra não fazer submit
        //                         '  <div><label>Dia:</label>'+
        //                         '    <select class="form-elements" name="pontos[' + n + '][dia]" id="dia' + n + '"> <option value="">Selecione...</option>' +
        //                         '    </select>'+
        //                         '  </div>' +
        //                         '  <div><label>Horário:</label><input type="text" class="form-elements horas" name="pontos[' + n + '][hora]" id="hora' + c + '" value="'+ ponto.hora +'" /></div>' +
        //                         '  <div><label>Valor:</label><input type="text" class="form-elements valores" name="pontos[' + n + '][valor]" id="valor' + c + '" value="'+ ponto.valor +'" /></div>' +
        //                         '</div>'
        //                     );
        //                     for(let w in diasSemana){
        //                         if(w == ponto.dia){
        //                             newOption = new Option(diasSemana[w], w, true, true);
        //                         } else {
        //                             newOption = new Option(diasSemana[w], w, false, false);
        //                         }
        //                         $("#dia" + (c + 1)).append(newOption);
        //                     }

        //                 });
        //             } else {
        //                 $("#pontosDiv").append(retorno.msg);
        //             }

        //             $(".valores").mask('#.##0,00', {
        //                 reverse: true
        //             });
        //             $(".horas").mask('00:00', {
        //                 reverse: true
        //             });


        //         } else {

        //         }
        //     },
        //     error: function(st) {
        //         show_message(st.status + ' ' + st.statusText, 'danger');
        //     },
        //     complete: function() {
        //         $(".horas").datetimepicker({
        //             format: "HH:mm",
        //         });

        //         $(".valores").mask('#.##0,00', {
        //             reverse: true
        //         });

        //         $(".cidadeAutocomplete").autocomplete({
        //             minLength: 2,
        //             delay: 100,
        //             source: function(request, response) {

        //                 $.ajax({
        //                     url: "/locais",
        //                     type: "post",
        //                     data: {
        //                         cidade: request.term
        //                     },
        //                     dataType: 'json',
        //                     success: function(retorno) {
        //                         response($.map(retorno.data, function(val, key) {

        //                             var label = val.cidade + ' - ' + val.uf;
        //                             return {
        //                                 label: label,
        //                                 value: label,
        //                                 id: val.id
        //                             };
        //                         }));
        //                     }
        //                 });
        //             },
        //             select: function(event, ui) {
        //                 console.log(event)
        //                 let id = $(event.target).data('id');
        //                 console.log($(event.target).data('id'), id)
        //                 $("#locais_id" + id).val(ui.item.id)
        //             }
        //         });

        //     }
        // });

        $("#hora").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        $("#valor").mask('#.##0,00', {
            reverse: true
        });
        $("#hora").mask('00:00', {
            reverse: true
        });

        $("#mediumModalLabel").html('Trechos da linha ' + (este.data('linhas_descricao') ? este.data('linhas_descricao') : ''));

        $("#formMediumModal").modal("show")
    });


    $("#btnSalvar").click(function() {
        var este = $(this);
        var id = $("#trechos_id").val();
        var form = $("#formTrecho");

        if ($("#linhas_id").val() == "") {
            show_message('Por favor, escolha uma linha', 'danger');
            $("#linhas_id").addClassTemp('form-elements-error', 2000).focus();
            return false;
        }

        if ($("#origem_id").val() == "") {
            show_message('Por favor, escolha um local de origem', 'danger');
            $("#origem").addClassTemp('form-elements-error', 2000).focus();
            return false;
        }

        $.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('/trechos/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {

                    show_message(retorno.msg, 'success', null, '/trechos');

                    let data_saida = new moment(retorno.data[0].data_saida);
                    let data_chegada = new moment(retorno.data[0].data_chegada);
                    $("#label_linha" + id).html(retorno.data[0].linha);
                    $("#label_origem_id" + id).html(retorno.data[0].origem_id);
                    $("#label_destino_id" + id).html(retorno.data[0].destino_id);
                    $("#label_data_saida" + id).html(data_saida.format('DD/MM/YYYY HH:mm'));
                    $("#label_data_chegada" + id).html(data_chegada.format('DD/MM/YYYY HH:mm'));
                    $("#label_veiculos_id" + id).html(retorno.data[0].marca + ' ' + retorno.data[0].modelo + ' ' + retorno.data[0].ano + ' ' + retorno.data[0].codigo + ' ' + retorno.data[0].placa);
                    $("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
                    $("#trecho" + id).addClass('success-transition');
                } else {
                    $("#trecho" + id).addClass('error-transition');
                    show_message(retorno.msg, 'danger')
                    if (retorno.data) {
                        for (var key in retorno.data) {
                            $("#" + key).parent('div').find('.error-label').html(retorno.data[key]);
                        }

                    }
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    $("#btnExcluir").click(function() {
        var id = $("#trechos_id").val();
        var rota = '<?= $this->siteUrl('trechos/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('trechos') ?>';
        excluir(rota, 'Você realmente quer excluir esta trecho?', redirect);
    });
</script>