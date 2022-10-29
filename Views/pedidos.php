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
                <div class="layout-flex flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Pedidos</h4>
                        <div class="small text-muted"> pedidos estão sendo exibidos</div>
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
                <?php $viagens = (array)$viagens->data; ?>

                <table id="bootstrap-data-table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="bootstrap-data-table_info">
                    <thead>
                        <tr>
                            <th>Pedidos</th>
                            <th>Código da viagem</th>
                            <th>Descrição da viagem</th>
                            <th>Data da viagem</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($pedidosViagens as $viagemId => $pedidosViagem) : ?>
                            <!-- informações da viagem -->
                            <tr>
                                <td><button class="btn btn-sm fas fa-chevron-right expandir" data-trtarget="pedidos<?= $viagemId ?>tr"><i class=""></i></button> (<?= count($pedidosViagem) ?>)</td>
                                <td><a href="<?= $this->siteUrl('viagens?key=' . $viagens[$viagemId]->key) ?>" title="Ver pedidos dessa viagem"><?= $viagens[$viagemId]->codigo ?></a></td>
                                <td><?= $viagens[$viagemId]->descricao ?></td>
                                <td><?= $this->dateFormat($viagens[$viagemId]->data_saida, 'd/m/Y H:i')?></td>
                                <td></td>
                            </tr>
                            <!-- informações do pedido -->
                            <tr id="pedidos<?= $viagemId ?>tr" style="display: none;">
                                <td colspan="5">
                                    <table id="pedidos<?= $viagemId ?>Table" class="table table-bordered dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <th>Assento</th>
                                                <th>Valor</th>
                                                <th>Status</th>
                                                <th>Data/Hora</th>
                                                <th><i class="fas fa-cog"></i></th>
                                            </tr>
                                        </thead>
                                        <?php 
                                        $statusClasses = [
                                            'R' => 'reservado',
                                            'P' => 'pago',
                                            'C' => 'cancelado',
                                        ];
                                        foreach ($pedidosViagem as $pedido) : ?>
                                            <tbody>
                                                <tr id="linha<?= $pedido->id ?>" class="list-label">
                                                    <td><span id="label_codigo<?= $pedido->id ?>"><?= $pedido->codigo ?></span></td>
                                                    <td><span id="label_cliente_nome<?= $pedido->id ?>"><?= $pedido->cliente_nome ?></span></td>
                                                    <td><span id="label_assento<?= $pedido->id ?>" class="label_assento"><?= $pedido->assento ?></span></td>
                                                    <td><span id="label_valor<?= $pedido->id ?>"><?= str_replace('.', ',', $pedido->valor ?? '') ?></span></td>
                                                    <td><span id="label_status<?= $pedido->id ?>"><span class="<?= $statusClasses[$pedido->status]??'' ?>"><?= ucfirst($statusClasses[$pedido->status]??'') ?></span></span></td>
                                                    <td><span id="label_data<?= $pedido->id ?>"><?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?></span></td>
                                                    <td>
                                                        <?php $session = $this->getAttributes();
                                                        $usersession = $session['userSession'] ?? false;
                                                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                                                            <!-- Editar -->
                                                            <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $pedido->id ?>" data-codigo="<?= $pedido->codigo ?>" data-clientes_id="<?= $pedido->clientes_id ?>"  data-cliente_nome="<?= $pedido->cliente_nome ?>" data-cliente_cpf="<?= $pedido->cliente_cpf ?>" data-viagens_id="<?= $pedido->viagens_id ?>" data-assento="<?= $pedido->assento ?>" data-valor="<?= str_replace('.', ',', $pedido->valor ?? '') ?>" data-status="<?= $pedido->status ?>" data-data_insert="<?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?>">
                                                                <i class="far fa-edit"></i> Editar</button>
                                                        <?php endif ?>
                                                        <!-- Favoritar -->
                                                        <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="pedidos" data-item_id="<?= $pedido->id ?>">
                                                            <?php if (isset($pedido->favoritos_id) && !empty($pedido->favoritos_id)) : ?>
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
                        <input type="hidden" id="clientes_id" name="clientes_id">
                        <span class="text-danger error-label"></span>
                        <!-- deixar sem name para não fazer submit -->
                        <input class="form-elements" id="clientes" data-target="clientes_id">
                        <button class="btn" id="btnAddCliente"><i class="fas fa-plus"></i> Adicionar cliente</button>
                    </div>

                    <div class="form-group" id="addClienteDiv" style="display: none; margin: 12px;">
                        <label>Dados do novo cliente</label>
                        <div class="form-group">
                            <label class="control-label mb-1" for="nome">Nome</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="nome" name="cliente[nome]" value="" placeholder="Nome" />
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-1" for="cpf">CPF</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="cpf" name="cliente[cpf]" value="" placeholder="CPF" />
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-1" for="rg">RG</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="rg" name="cliente[rg]" value="" placeholder="RG" />
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-1" for="celular">Celular</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="celular" name="cliente[celular]" value="" placeholder="Celular" />
                        </div>
                        <div class="form-group">
                            <label class="control-label mb-1" for="email">E-mail</label>
                            <span class="text-danger error-label"></span>
                            <input type="text" class="form-elements" id="email" name="cliente[email]" value="" placeholder="E-mail" />
                        </div>
                    </div>

                    <div class="form-group" style="border: 1px solid; padding: 8px;">
                        <label class="control-label mb-1" for="origem">Origem</label>
                        <input type="hidden" id="origem_id">
                        <span class="text-danger error-label"></span>
                        <!-- deixar sem name para não fazer submit -->
                        <input class="form-elements cidadeAutocomplete" id="origem" data-target="origem_id">
                        
                        <label class="control-label mb-1" for="destino">Destino</label>
                        <input type="hidden" id="destino_id">
                        <span class="text-danger error-label"></span>
                        <!-- deixar sem name para não fazer submit -->
                        <input class="form-elements cidadeAutocomplete" id="destino" data-target="destino_id">

                        <label class="control-label mb-1" for="data">Data</label>
                        <input type="text" class="form-control datas" id="data_saida" />
                        <span class="text-danger error-label"></span>
                        

                        <button class="btn btn-secondary" id="btnLocalizarViagem" title="Localizar trecho"><i class="fas fa-search" ></i></button>
                        
                        <input type="hidden" id="trechos_id" name="trechos_id" />
                        <input type="hidden" id="viagens_id" name="viagens_id" />
                        
                        <div id="trecho_info">trecho_info</div>

                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="assento">Assento</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="assento" name="assento" value="" placeholder="Assento" />
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
    jQuery('#valor').mask("#.##0,00", {reverse: true});

    jQuery(".datas").mask('00/00/0000 00:00');
    jQuery("#cpf").mask('000.000.000-00');
    jQuery("#celular").mask('00 00000-0000');

    jQuery(".datas").datetimepicker({
        format: "DD/MM/YYYY"
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
        jQuery("#clientes").val((este.data('cliente_nome')?este.data('cliente_nome')+' - '+(este.data('cliente_cpf')??''): ''));
        jQuery("#viagens_id").val(este.data('viagens_id'));
        jQuery("#assento").val(este.data('assento'));
        jQuery("#valor").val(este.data('valor')?.replace('.', ',')).mask("#.##0,00", {
            reverse: true
        });
        jQuery("#status").val(este.data('status'));
        jQuery("#mediumModalLabel").html('Pedido ' + (este.data('codigo') ? este.data('codigo') : ''));

        jQuery("#formMediumModal").modal("show");
        jQuery(".cidadeAutocomplete").keyup(function(){
            autocompleteLocais($(this), "/locais/listar");
        });

    });

    
    $("#btnLocalizarViagem").click(function(evt){
        evt.preventDefault();
        var origem_id = $("#origem_id").val();
        var destino_id = $("#destino_id").val();
        var data_saida = $("#data_saida").val();

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('viagens/procurar')?>',
            data: {
                origem_id: origem_id,
                destino_id: destino_id,
                data_saida: data_saida
            },
            dataType: 'json',
            beforeSend: function (){},
            success: function (retorno) {
                console.log('btnLocalizarTrecho -> retorno', retorno);
                if (retorno.status == true) {
                    // $("#trechos_id").val(retorno.data[0].id);
                    $("#trecho_info").html('<h5>'+retorno.msg+'</h5>')
                    let viagem,trecho;
                    for(let key in retorno.data){
                        console.log(key +' => '+ retorno.data[key])
                        viagem = retorno.data[key].viagem;
                        trecho = retorno.data[key].trecho;
                        $("#trecho_info").append(
                            '<h5>Informações da viagem localizada</h5>'+
                            '<div class="layout-grid gap grid-3col layout-dados">'+
                            '  <div>id: '+ viagem.id +'</div>'+
                            '  <div>key: '+ viagem.codigo +'</div>'+
                            '  <div>linhas_id: '+ viagem.linhas_id +'</div>'+
                            '  <div>descricao: '+ viagem.descricao +'</div>'+
                            '  <div>detalhes: '+ viagem.detalhes +'</div>'+
                            '  <div>data_saida: '+ viagem.data_saida +'</div>'+
                            '  <div>assentos: '+ viagem.assentos +'</div>'+
                            '  <div>assentos_tipo: '+ viagem.assentos_tipo +'</div>'+
                            '</div>'+
                            '<h5>Informações do trecho </h5>'+
                            '<div class="layout-grid gap grid-2col layout-dados">'+
                            '  <div>Linha: '+ trecho.linhas_descricao +'</div>'+
                            '  <div>Origem: '+ trecho.origem_cidade +' ('+ trecho.origem_sigla +') - ' + trecho.origem_uf +' '+ trecho.origem_endereco +'</div>'+
                            '  <div>Destino: '+ trecho.destino_cidade +' ('+ trecho.destino_sigla +') - '+ trecho.destino_uf +' '+ trecho.destino_endereco +'</div>'+
                            '  <div>Horário: '+ trecho.hora +'</div>'+
                            '  <div>Dias: '+ trecho.dias +'</div>'+
                            '  <div class="valores">Valor: '+ trecho.valor +'</div>'+
                            '</div>'
                        );
                    }
                } else {
                    $("#trechos_id").val('');
                    $("#trecho_info").html('<h5>'+retorno.msg+'</h5>')
                }
            },
            error: function (st){
                show_message( st.status +' '+ st.statusText, 'danger');
            },
            complete: function(){
                $('.valores').mask("Valor: #.##0,00", {reverse: true});
            }
        });    
    });

    $("#btnAddCliente").click(function(evt) {
        evt.preventDefault()
        $("#addClienteDiv").toggle('slow');
    });

    $("#clientes").change(function(evt) {
        if ($(this).val() == '') {
            $("#clientes_id").val('')
        }
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

                    show_message(retorno.msg, 'success', null, 'pedidos');

                    let data = new moment(retorno.data[0].dataInsret);

                    jQuery("#label_codigo" + id).html(retorno.data[0].descricao);
                    jQuery("#label_cliente_nome" + id).html(retorno.data[0].cliente_nome);
                    jQuery("#label_viagens_descricao" + id).html(retorno.data[0].viagens_descricao);
                    jQuery("#label_assento" + id).html(data.assento);
                    jQuery("#label_valor" + id).html((retorno.data[0].valor).replace('.', ','));
                    jQuery("#label_status" + id).html(retorno.data[0].status);
                    jQuery("#linha" + id).addClass('success-transition');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                    show_message(retorno.msg, 'danger');
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

    $(".expandir").click(function() {
        var este = $(this);
        var idtrTarget = este.data('trtarget');
        var trTarget = $('#' + idtrTarget);
        console.log(idtrTarget, trTarget)
        if (trTarget.is(":visible")) {
            este.removeClass('fa-chevron-down').addClass('fa-chevron-right');
            trTarget.hide('slow')
        } else {
            este.removeClass('fa-chevron-right').addClass('fa-chevron-down');
            trTarget.show('slow')
        }
    })

    $("body").on('keyup', '#clientes', function(evt) {

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90)) {

            autocompleteClientes($(this));
        }
    })
</script>