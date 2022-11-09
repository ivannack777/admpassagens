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

<div class="modal" id="formMediumModal" tabindex="-1" role="dialog" aria-labelledby="mediumModalLabel" aria-hidden="true" tabindex="-1" data-width="960">
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
                        <label class="control-label mb-1" for="trechos">Trechos</label>
                        <span class="error-label"></span>
                        <div id="pontosEmbarqueDiv" class="hide-last-last">

                        </div>

                        <button class="btn btn-outline-secondary" id="addtrechos">+</button>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="dias">Dias da semana</label>
                        <span class="error-label"></span>
                        <select type="text" class="form-control" id="dias" name="dias[]" multiple>
                            <?php
                            $diasSemana = $this->diasSemana();
                            foreach ($diasSemana as $d => $diasSemana) : ?>
                                <option value="<?= $d ?>"><?= $diasSemana ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="hora">Horário saída</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-control horas" id="hora" name="hora">
                            
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
    

    jQuery('#dias').select2({
        dropdownParent: jQuery('#formMediumModal'),
        class: 'form-elements',
        closeOnSelect: false,
        placeholder:'Selecione...',
        allowClear: true
    });

    // jQuery("#addtrechos").click(function(evt) {
    //     evt.preventDefault();
    //     createPontoEmbarque()
    //     jQuery(".horas").datetimepicker({
    //         format: "HH:mm",
    //         stepping: 10
    //     });

    //     jQuery(".valores").mask('#.##0,00', {
    //         reverse: true
    //     });
    //     jQuery(".horas").mask('00:00', {
    //         reverse: true
    //     });

    // });

    function createPontoEmbarque(dado=false){
        console.log(dado);

        var qtd = jQuery('.trechoDiv').length +1
            
        jQuery("#pontosEmbarqueDiv").append(
            ' <div class="trechoDiv layout-grid layout-dados layout-margin" style="position: relative; grid-template-columns: 1fr 8fr 4fr 2fr 2fr;">' +
            '  <div><div class="circle font-20 bold6"> ' + qtd + '</div></div>' +
            //'  <input type="hidden" id="id'+ qtd +'" name="trechos[' + qtd + '][id]" value="' + (dado?dado.id:'') + '" />' +
            //'  <input type="hidden" id="trechos_id'+ qtd +'" name="trechos[' + qtd + '][trechos_id]" value="' + (dado?dado.trechos_id:'') + '" />' +
            '  <div class="form-group"><label>Local</label>' + (dado ? dado.cidade +' ('+ dado.sigla + ') - '+ dado.uf :'') + '</div>' +
            '  <div class="form-group"><label>Dias da semana</label>'+ (dado.diasSemanaTextBrev?(dado.diasSemanaTextBrev).join(', '):'') +'</div>' +
            '  <div class="form-group"><label>Horário</label><span> ' + (dado?dado.hora:'') + '</span></div>' +
            '  <div class="form-group"><label>Valor</label><span class="valores" style="text-align: right;"> ' + (dado?dado.valor:'') + '</span></div>' +
            '  <div style="position: absolute; bottom: -30px; left: 18px;"><i class="fas fa-arrow-down fa-2x" style="color: #408ba9"></div>' +
            '</div>'
        );


        jQuery(".trechoAutocomplete").autocomplete({
            minLength: 2,
            delay: 100,
            source: function(request, response) {

                jQuery.ajax({
                    url: "/linhas/pontos",
                    type: "post",
                    data: {
                        cidade: request.term
                    },
                    dataType: 'json',
                    success: function(retorno) {
                        response(jQuery.map(retorno.data, function(val, key) {
                            
                            var label = val.origem_cidade + ' (' + val.origem_sigla + ') - ' + val.origem_uf +' -> '+ val.destino_cidade + ' (' + val.destino_sigla + ') - ' + val.destino_uf;
                            return {
                                label: label,
                                value: label,
                                id: val.trechos_id
                            };
                        }));
                    }
                });
            },
            select: function(event, ui) {
                let index = jQuery(event.target).data('index');
                jQuery("#trechos_id" + index).val(ui.item.id)
            }
        });

    }

    jQuery(".editar").click(function() {
        // qtdPontos = jQuery("#pontosEmbarqueDiv").find('.trechos');
        // qtdPontos = qtdPontos.length;
        var este = jQuery(this);
        var id = este.data('id');

        jQuery("#linhas_id").val(este.data('id'));
        jQuery("#descricao").val(este.data('descricao'));
        jQuery("#valor").val(este.data('valor'));
        jQuery("#assentos").val(este.data('assentos'));
        jQuery("#dias").val(este.data('dias')?.toString().split(',')).trigger('change');
        jQuery("#hora").val(este.data('hora'));

        $("input.horas").datetimepicker({
            format: "HH:mm",
            stepping: 10
        });

        jQuery("#pontosEmbarqueDiv").html('');
        if(id){
            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('linhas/pontos') ?>',
                data: {
                    linhas_id: id
                },
                dataType: 'json',
                beforeSend: function() {
                    jQuery("#pontosEmbarqueDiv").html('Aguarde...');
                },
                success: function(retorno) {
                    if (retorno.status == true) {
                        jQuery("#pontosEmbarqueDiv").html('');
                        if (retorno.data.length) {
                            
                            jQuery.each(retorno.data, function(c, ponto) {
                                // qtdPontos = c +1;
                                createPontoEmbarque(ponto);
                                // jQuery("#pontosEmbarqueDiv").append(
                                //     createPontoEmbarque(qtdPontos, trecho)
                                // );

                                
                            });
                        } else {
                            jQuery("#pontosEmbarqueDiv").append(retorno.msg);
                        }

                    } else {

                    }
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {
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


                }
            });
        }



        jQuery("#mediumModalLabel").html('Linha ' + (este.data('descricao') ? este.data('descricao') : ''));

        jQuery("#formMediumModal").modal("show")
    });


    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#linhas_id").val();
        var form = jQuery("#formLinha");

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