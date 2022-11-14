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
                            <th>Descrição</th>
                            <th>Dias</th>
                            <th>Horário</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($linhas->data as $linha) :
                            $dias = explode(',', $linha->dias);
                            $diasExt = [];
                            foreach ($dias as $dia) {
                                $diasExt[] = $this->diasSemana($dia, true);
                            }
                        ?>
                            <tr id="linha<?= $linha->linhas_id ?>" class="list-label">
                                <td><span id="label_descricao<?= $linha->linhas_id ?>"><?= $linha->descricao ?></span></td>
                                <td><span id="label_dias<?= $linha->linhas_id ?>"><?= implode(', ', $diasExt) ?></span></td>
                                <td><span id="label_hora<?= $linha->linhas_id ?>"><?= $linha->hora ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $linha->linhas_id ?>" data-descricao="<?= $linha->descricao ?>" 
                                        data-dias="<?= $linha->dias ?>"
                                        data-hora="<?= $linha->hora ?>"
                                        >
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="linhas" data-item_id="<?= $linha->linhas_id ?>">
                                        <?php if (isset($linha->favoritos_id) && !empty($linha->favoritos_id)) : ?>
                                            <i class="fas fa-heart"></i>
                                        <?php else : ?>
                                            <i class="far fa-heart"></i>
                                        <?php endif ?>
                                    </button>
                                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="linhas" data-item_id="<?= $linha->linhas_id ?>" data-title="<?= $linha->descricao ?>">
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

<div class="modal" id="formLinhasModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" tabindex="-1" data-width="960">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Linha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formLinha">
                    <input type="hidden" id="linhas_id" name="linhas_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="descricao">Descrição</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements" id="descricao" name="descricao" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="">Pontos</label>
                        <span class="error-label"></span>
                        <div id="pontosEmbarqueDiv" class="hide-last-last">

                        </div>

                        <button class="btn btn-outline-secondary" id="addPontos">+</button>
                    </div>

                    <!-- <div class="form-group">
                        <label class="control-label mb-1" for="dias">Dias da semana</label>
                        <span class="error-label"></span>
                        <select type="text" class="form-control" id="dias" name="dias[]" multiple>
                            <?php
                            $diasSemana = $this->diasSemana();
                            foreach ($diasSemana as $d => $diasSemana) : ?>
                                <option value="<?= $d ?>"><?= $diasSemana ?></option>
                            <?php endforeach ?>
                        </select>
                    </div> -->
                    <!-- <div class="form-group">
                        <label class="control-label mb-1" for="hora">Horário saída</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-control horas" id="hora" name="hora">
                            
                    </div> -->
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
    

    $('#dias').select2({
        dropdownParent: $('#formLinhasModal'),
        class: 'form-elements',
        closeOnSelect: false,
        placeholder:'Selecione...',
        allowClear: true
    });

    $("#addPontos").click(function(evt) {
        evt.preventDefault();
        createPontoEmbarque()
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

    function createPontoEmbarque(dado=false){
        console.log(dado);

        var qtd = $('.pontoDiv').length +1
            
        $("#pontosEmbarqueDiv").append(
            ' <div class="pontoDiv layout-grid layout-dados layout-margin" style="position: relative; grid-template-columns: 1fr 8fr 4fr 2fr 1fr;">' +
            '  <div><div class="circle font-20 bold6"> ' + qtd + '</div></div>' +
            '  <input type="hidden" id="id'+ qtd +'" name="pontos[' + qtd + '][id]" value="' + (dado?dado.id:'') + '" />' +
            '  <input type="hidden" id="locais_id'+ qtd +'" name="pontos[' + qtd + '][locais_id]" value="' + (dado?dado.locais_id:'') + '" />' +
            '  <input type="hidden" id="ordem'+ qtd +'" class="ordem" name="pontos[' + qtd + '][ordem]" value="' + (dado?dado.locais_id:'') + '" />' +
            '  <div class="form-group"><label>Local</label><input type="text" class="form-elements pontoAutocomplete" value="' + (dado ? dado.cidade +' ('+ (dado.sigla??'') + ') - '+ dado.uf :'') + '" data-index="'+ qtd +'" /></div>' +
            '  <div class="form-group"><label>Dias da semana</label>'+
            '    <select type="text" class="form-elements dias" id="dias'+ qtd +'" name="pontos[' + qtd + '][dias][]" multiple>'+
                    <?php
                    $diasSemana = $this->diasSemana(false, true);
                    foreach ($diasSemana as $d => $diasSemana) : ?>
            '         <option value="<?= $d ?>"><?= $diasSemana ?></option>'+
                    <?php endforeach ?>
            '     </select></div>' +
            '  <div class="form-group"><label>Horário</label><input type="text" class="form-elements horas" id="hora'+ qtd +'" name="pontos['+ qtd +'][hora]" value="' + (dado?dado.hora:'') + '" /></div>' +
            '<div style="position: absolute; bottom: -30px; left: 18px;"><i class="fas fa-arrow-down fa-2x" style="color: #408ba9"></i></div>'+
            '</div>'
        );

        $("#dias"+ qtd).select2({
            dropdownParent: $('#formLinhasModal'),
            class: 'form-elements',
            closeOnSelect: false,
            placeholder:'Selecione...',
            allowClear: true
        }).val(dado.diasSemana).trigger('change');
        
        $("input.horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        $(".horas").mask('00:00', {
            reverse: true
        });

        
        $( "#pontosEmbarqueDiv" ).sortable({
            appendTo: $("#formLinhasModal"),
            opacity: 0.5,
            stop: function( event, ui ) {
                //reordenar pontos
                var pontos = $('#pontosEmbarqueDiv').find('.circle');
                let ordem = 0;
                for(let pt of pontos){
                    ordem++;
                    console.log('pt', pt,$(pt).parents('div.pontoDiv').find('input.ordem'))
                    $(pt).text(ordem);
                    $(pt).parents('div.pontoDiv').find('input.ordem').val(ordem)

                }
            }
        });

        $(".pontoAutocomplete").autocomplete({
            minLength: 2,
            delay: 100,
            source: function(request, response) {

                $.ajax({
                    url: "/locais/listar",
                    type: "post",
                    data: {
                        cidade: request.term
                    },
                    dataType: 'json',
                    success: function(retorno) {
                        response($.map(retorno.data, function(val, key) {
                            
                            var label = val.cidade + ' (' + val.sigla + ') - ' + val.uf;
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
                let index = $(event.target).data('index');
                $("#locais_id" + index).val(ui.item.id);
                console.log( 'locais_id', $("#locais_id" + index))
            }
        });

    }

    $(".editar").click(function() {
        // qtdPontos = $("#pontosEmbarqueDiv").find('.pontos');
        // qtdPontos = qtdPontos.length;
        var este = $(this);
        var id = este.data('id');

        $("#linhas_id").val(este.data('id'));
        $("#descricao").val(este.data('descricao'));
        $("#valor").val(este.data('valor'));
        $("#assentos").val(este.data('assentos'));
        $("#dias").val(este.data('dias')?.toString().split(',')).trigger('change');
        $("#hora").val(este.data('hora'));

        $("input.horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        $("#pontosEmbarqueDiv").html('');
        if(id){
            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('linhas/pontos') ?>',
                data: {
                    linhas_id: id
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#pontosEmbarqueDiv").html('Aguarde...');
                },
                success: function(retorno) {
                    if (retorno.status == true) {
                        $("#pontosEmbarqueDiv").html('');
                        if (retorno.data.length) {
                            
                            $.each(retorno.data, function(c, ponto) {
                                // qtdPontos = c +1;
                                createPontoEmbarque(ponto);
                                // $("#pontosEmbarqueDiv").append(
                                //     createPontoEmbarque(qtdPontos, ponto)
                                // );

                                
                            });
                        } else {
                            $("#pontosEmbarqueDiv").append(retorno.msg);
                        }

                    } else {

                    }
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {
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


                }
            });
        }



        $("#mediumModalLabel").html('Linha ' + (este.data('descricao') ? este.data('descricao') : ''));

        $("#formLinhasModal").modal("show")
    });


    $("#btnSalvar").click(function() {
        var este = $(this);
        var id = $("#linhas_id").val();
        var form = $("#formLinha");

        $.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('linhas/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {

                    show_message(retorno.msg, 'success', null, '/linhas');

                    let data_saida = new moment(retorno.data[0].data_saida);
                    let data_chegada = new moment(retorno.data[0].data_chegada);
                    $("#label_descricao" + id).html(retorno.data[0].descricao);
                    $("#label_origem_id" + id).html(retorno.data[0].origem_id);
                    $("#label_destino_id" + id).html(retorno.data[0].destino_id);
                    $("#label_data_saida" + id).html(data_saida.format('DD/MM/YYYY HH:mm'));
                    $("#label_data_chegada" + id).html(data_chegada.format('DD/MM/YYYY HH:mm'));
                    $("#label_veiculos_id" + id).html(retorno.data[0].marca + ' ' + retorno.data[0].modelo + ' ' + retorno.data[0].ano + ' ' + retorno.data[0].codigo + ' ' + retorno.data[0].placa);
                    $("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
                    $("#linha" + id).addClass('success-transition');
                } else {
                    $("#linha" + id).addClass('error-transition');
                    // $("#retornomsg").html(retorno.msg).removeClass().addClass('text-danger');
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
        var id = $("#linhas_id").val();
        var rota = '<?= $this->siteUrl('linhas/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('linhas') ?>';
        excluir(rota, 'Você realmente quer excluir esta linha?', redirect);
    });
</script>