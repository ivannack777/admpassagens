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
                            <button id="btnAdicionar" type="button" class="btn btn-primary bg-flat-color-1"><i class="fas fa-plus"></i> Adicionar trecho</button>
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
                            <th>Linha</th>
                            <th>Local origem</th>
                            <th>Local destino</th>
                            <!-- <th>Horário</th> -->
                            <th>Valor</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($trechos->data as $trecho): ?>
                            <tr id="trecho<?= $trecho->trechos_id ?>" class="list-label">
                                <td><span id="label_linha<?= $trecho->trechos_id ?>"><?= $trecho->linhas_descricao ?></span></td>
                                <td><span id="label_origem_id<?= $trecho->trechos_id ?>"><a href="<?= $this->siteUrl('trechos?origem_key=' . $trecho->origem_key) ?>"> <?= $trecho->origem_cidade ?> - <?= $trecho->origem_uf ?></a></span></td>
                                <td><span id="label_destino_id<?= $trecho->trechos_id ?>"><a href="<?= $this->siteUrl('trechos?destino_key=' . $trecho->destino_key) ?>"> <?= $trecho->destino_cidade ?> - <?= $trecho->destino_uf ?></a></span></td>
                                <!-- <td><span id="label_hora_id<?= $trecho->trechos_id ?>" class="horas"><?= $trecho->hora ?></span></td> -->
                                <td><span id="label_valor_id<?= $trecho->trechos_id ?>" class="valores"><?= number_format($trecho->valor, 2, ',', '') ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $trecho->trechos_id ?>" data-linhas_id="<?= $trecho->linhas_id ?>" 
                                        data-linhas_descricao="<?= $trecho->linhas_descricao ?>" data-origem_id="<?= $trecho->origem_id ?>" 
                                        data-origem="<?= $trecho->origem_cidade ?> - <?= $trecho->origem_uf ?>/ <?= $trecho->origem_endereco ?>" 
                                        data-destino_id="<?= $trecho->destino_id ?>" data-destino="<?= $trecho->destino_cidade ?> - <?= $trecho->destino_uf ?>/ <?= $trecho->destino_endereco ?>" 
                                        data-hora="<?= $trecho->hora ?>" 
                                        data-valor="<?= number_format($trecho->valor, 2, ',', '') ?>" data-dias="<?= $trecho->dias ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="trechos" data-item_id="<?= $trecho->trechos_id ?>">
                                        <?php if (isset($trecho->favoritos_id) && !empty($trecho->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="trechos" data-item_id="<?= $trecho->trechos_id ?>" 
                                    data-title="<?= $trecho->linhas_descricao ?> (<?= $trecho->origem_cidade ?> - <?= $trecho->origem_uf ?> -> <?= $trecho->destino_cidade ?> - <?= $trecho->destino_uf ?>)">
                                        <i class="far fa-comment"></i>
                                    </button>
                                </td>
                            </tr>

                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div> <!-- .content -->

<div class="modal fade" id="formTrechoModal" tabindex="-1" role="dialog" aria-labelledby="formTrechoModalLabel" aria-hidden="true" data-width="960">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formTrechoModalLabel"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formTrecho">
                    <input type="hidden" id="trechos_id" name="trechos_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="linha">Linha</label>
                        <span class="error-label"></span>
                        <select type="text" class="form-elements" id="linhas_id" name="linhas_id">
                            <option value="">Selecione...</option>
                            <?php
                            foreach ($linhas->data as $linha) : ?>
                                <option value="<?= $linha->linhas_id ?>"><?= $linha->descricao ?></option>
                            <?php endforeach ?>
                        </select>

                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="origem_id">Local de origem</label>
                        <span class="error-label"></span>
                        <input type="hidden" id="origem_id" name="origem_id" />
                        <!--deixar sem name pra não fazer submit -->
                        <input type="text" class="form-elements cidadeAutocomplete" id="origem" data-target="origem_id" />
                    </div>
                    <div id="pontosDivGroup">
                        <div class="form-group">
                            <label class="control-label mb-1" for="destino_id">Locais de destino</label>
                            <div id="pontosDiv"></div>
                            
                            <!--deixar sem name pra não fazer submit -->
                        </div>
                        <button type="text" class="btn btn-outline-info" id="addPontos"><i class="fas fa-plus"></i> Adicionar ponto</button>
                    </div>

                    <div class="form-group" id="destinoDiv" style="display: none;">
                        <label class="control-label mb-1" for="destino_id">Local de destino</label>
                        <span class="error-label"></span>
                        <input type="hidden" id="destino_id" name="destino_id" />
                        <!-- deixar sem name pra não fazer submit -->
                        <input type="text" class="form-elements cidadeAutocomplete" id="destino" data-target="destino_id" />
                    </div>

                    <div class="form-group" id="valorDiv" style="display: none;">
                        <label class="control-label mb-1" for="destino_id">Valor</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements valores" id="valor" name="valor" placeholder="Valor" />
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

    $('#dias').select2({
        dropdownParent: $('#formTrechoModal'),
        class: 'form-elements',
        closeOnSelect: false
    });

    $('#linhas_id').select2({
        dropdownParent: $('#formTrechoModal'),
        class: 'form-elements',
        closeOnSelect: true
    });

    $("input.horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

    $("#addPontos").click(function(evt) {
        evt.preventDefault();
        var c = $('.pontoDiv').length + 1;
        $("#pontosDiv").append(
            ' <div class="pontoDiv layout-grid layout-dados layout-margin" style="position: relative; grid-template-columns: 1fr 8fr 4fr 2fr;">' +
            '  <div><i class="fas fa-level-up-alt fa-2x fa-fw fa-rotate-90" style="color: #408ba9"></i></div>' +
            '  <input type="hidden" class="pontos" id="destino_id' + c + '" name="pontos[' + c + '][destino_id]" value="" />' +
            '  <div class="form-group"><label>Destino</label><input type="text" class="form-elements cidadeAutocomplete" id="destino' + c + '" value="" data-id="' + c + '" data-target="destino_id' + c + '" /></div>' + //deixar sem name pra não fazer submit
            '  <div class="form-group"><label>Dias:</label>' +
            '    <select class="form-elements dias" name="pontos[' + c + '][dias]" id="dias' + c + '" multiple="" style="width: 100px;">' +
            '<?php $diasSemana = $this->diasSemana(false, true);
                foreach ($diasSemana as $d => $diasSemana) : ?> <option value="<?= $d ?>"><?= $diasSemana ?></option><?php endforeach ?>' +
            '    </select>' +
            '  </div>' +
            //'  <div class="form-group"><label>Horário:</label><input type="text" class="form-elements horas" name="pontos[' + c + '][hora]" id="hora' + c + '" value="" /></div>' +
            '  <div class="form-group"><label>Valor:</label><input type="text" class="form-elements valores" name="pontos[' + c + '][valor]" id="valor' + c + '" value="" /></div>' +
            '</div>'
        );

        $("input.horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        $(".valores").mask('#.##0,00', {
            reverse: true
        });
        $(".horas").mask('00:00', {
            reverse: true
        });

        $(".dias").select2({
            placeholder:'',
            closeOnSelect: false
        });
        $('#destino' + c ).focus();


    });

    $("body").on('keyup', '.cidadeAutocomplete', function(evt) {

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90)) {
            console.log(".cidadeAutocomplete", evt.keyCode)
            autocompleteLocais($(this));
        }
    })

    $("#btnAdicionar").click(function() {
        $("#formTrechoModalLabel").html("Adicionar um novo trecho");
        $("#formTrecho")[0].reset();
        $("#destinoDiv").hide();
        $("#valorDiv").hide();
        $("#pontosDivGroup").show();
        $("#formTrechoModal").modal("show")
    });

    $(".editar").click(function() {
        // qtdPontos = $("#pontosDiv").find('.pontos');
        // qtdPontos = qtdPontos.length;
        var este = $(this);
        var id = este.data('id');
        var dias = String(este.data('dias')).split(',');

        // if (este.data('dias')) {
        //     console.log(este.data('dias').split(','))
        //     $('#dias option[value="' + este.data('dias').split(',') + '"]').prop('selected', true);
        // } else {
        //     $('#dias option[value="0"]').prop('selected', true);
        // }

        $("#trechos_id").val(este.data('id'));
        $("#linha").val(este.data('linha'));
        $("#linhas_id").val(este.data('linhas_id')).trigger('change').focus();
        $("#linha").val(este.data('linha'));
        $("#origem_id").val(este.data('origem_id'));
        $("#origem").val(este.data('origem'));
        $("#destino_id").val(este.data('destino_id'));
        $("#destino").val(este.data('destino'));
        $("#valor").val(este.data('valor'));
        $("#hora").val(este.data('hora'));
        $("#dias").select2().val(dias).trigger('change');

        if(este.data('linhas_id') !=''){
            $("#destinoDiv").show('slow');
            $("#valorDiv").show('slow');
            $("#pontosDivGroup").hide('slow');
        }
        $(".valores").mask('#.##0,00', {
            reverse: true
        });
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
        //                         '    <select class="form-elements" name="pontos[' + n + '][dias]" id="dias' + n + '"> <option value="">Selecione...</option>' +
        //                         '    </select>'+
        //                         '  </div>' +
        //                         '  <div><label>Horário:</label><input type="text" class="form-elements horas" name="pontos[' + n + '][hora]" id="hora' + c + '" value="'+ ponto.hora +'" /></div>' +
        //                         '  <div><label>Valor:</label><input type="text" class="form-elements valores" name="pontos[' + n + '][valor]" id="valor' + c + '" value="'+ ponto.valor +'" /></div>' +
        //                         '</div>'
        //                     );
        //                     for(let w in diasSemana){
        //                         if(w == ponto.dias){
        //                             newOption = new Option(diasSemana[w], w, true, true);
        //                         } else {
        //                             newOption = new Option(diasSemana[w], w, false, false);
        //                         }
        //                         $("#dias" + (c + 1)).append(newOption);
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

        $("#formTrechoModalLabel").html('Trechos da linha ' + (este.data('linhas_descricao') ? este.data('linhas_descricao') : ''));

        $("#formTrechoModal").modal("show")
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