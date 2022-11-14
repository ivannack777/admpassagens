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
                    <li class="active"><a href="<?= $this->siteUrl('pedidos/status') ?>" title="Configurar status de pedidos"><i class="fas fa-cog"></i> Status</a></li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="content mt-3">


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
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar" id="btnAdicionarPedido" title="Adicionar pedido"><i class="fas fa-plus"></i> Adicionar pedido</button>
                        <?php endif ?>
                    </div>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">
                            <form action="<?= $this->siteUrl('pedidos') ?>" method="GET">

                                <div class="form-elements-group">
                                    <input type="text" class="busca" name="busca" id="busca" value="<?= $_GET['busca'] ?? '' ?>" title="Termos para a busca" placeholder="" style="width: 8em;" />
                                    <input type="text" class="datas" name="data_ini" id="data_ini" value="<?= $_GET['data_ini'] ?? '' ?>" title="Data inicial" placeholder="Data inicial" style="width: 6em;" />
                                    <input type="text" class="datas" name="data_fim" id="data_fim" value="<?= $_GET['data_ini'] ?? '' ?>" title="Data final" placeholder="Data final" style="width: 6em;" />
                                    <button type="submit" class="btn btn-info" id="btnBuscar" title="Pesquisar"><i class="fa fa-search"></i></button>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

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
                                <td><?= $this->dateFormat($viagens[$viagemId]->data_saida, 'd/m/Y H:i') ?></td>
                                <td><a href="<?= $this->siteUrl('pedidos/download?viagens_codigo=' . $viagens[$viagemId]->codigo) ?>"><i class="far fa-file-excel"></i> Baixar</span></td>
                            </tr>
                            <!-- informações do pedido -->
                            <tr id="pedidos<?= $viagemId ?>tr" style="display: none;">
                                <td colspan="5">
                                    <table id="pedidos<?= $viagemId ?>Table" class="table table-bordered dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th>Código</th>
                                                <th>Cliente</th>
                                                <!-- <th>Assento</th> -->
                                                <th>Valor</th>
                                                <th>Status</th>
                                                <th>Data/Hora</th>
                                                <th>Dados para pagamento</th>
                                                <th><i class="fas fa-cog"></i></th>
                                            </tr>
                                        </thead>
                                        <?php
                                        $statusClasses = [
                                            'R' => 'reservado',
                                            'P' => 'pago',
                                            'C' => 'cancelado',
                                        ];
                                        foreach ($pedidosViagem as $pedido) :

                                        ?>
                                            <tbody>
                                                <tr id="linha<?= $pedido->id ?>" class="list-label">
                                                    <td><span id="label_codigo<?= $pedido->id ?>"><?= $pedido->codigo ?></span></td>
                                                    <td><span id="label_pessoa_nome<?= $pedido->id ?>"><?= $pedido->pessoas_nome ?></span></td>
                                                    <!-- <td><span id="label_assento<?= $pedido->id ?>" class="label_assento"><?= $pedido->assento ?></span></td> -->
                                                    <td><span id="label_valor<?= $pedido->id ?>"><?= str_replace('.', ',', $pedido->valor ?? '') ?></span></td>
                                                    <td><span id="label_status<?= $pedido->id ?>"><span class="<?= $statusClasses[$pedido->status] ?? '' ?>"><?= ucfirst($statusClasses[$pedido->status] ?? '') ?></span></span></td>
                                                    <td><span id="label_data<?= $pedido->id ?>"><?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?></span></td>
                                                    <td>
                                                        Link: <a href="<?= $pedido->pagamento_link ?>" title="Link de pagamento" target="_BLANK"><?= $pedido->pagamento_link ?></a>
                                                        Status pagamento: <?= $pedido->pagamento_status ?>
                                                        Detalhes do pagamento: <?= $pedido->pagamento_status_detalhe ?>
                                                    </td>
                                                    <td>
                                                        <?php $session = $this->getAttributes();
                                                        $usersession = $session['userSession'] ?? false;
                                                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                                                            <!-- Editar -->
                                                            <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $pedido->id ?>" data-codigo="<?= $pedido->codigo ?>" data-pessoas_id="<?= $pedido->pessoas_id ?>" data-pessoas_nome="<?= $pedido->pessoas_nome ?>" data-quantidade="<?= $pedido->quantidade ?>" data-pessoas_cpf="<?= $pedido->pessoas_cpf ?>" data-viagens_id="<?= $pedido->viagens_id ?>" data-assento="<?= $pedido->assento ?>" data-valor="<?= str_replace('.', ',', $pedido->valor ?? '') ?>" data-status="<?= $pedido->status ?>" data-trechos_id="<?= $pedido->trechos_id ?>" data-linhas_id="<?= $pedido->linhas_id ?? 0 ?>" data-data_insert="<?= $this->dateFormat($pedido->data_insert, 'd/m/Y H:i') ?>">
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
        </div>
    </div>
</div> <!-- .content -->

<div class="modal fade" id="formPedidoModal" tabindex="-1" role="dialog" aria-labelledby="formPedidoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formPedidoModalLabel">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formViagem">
                    <input type="hidden" id="pedidos_id" name="pedidos_id" value="0" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="pessoas_id">Cliente</label>
                        <input type="hidden" id="pessoas_id" name="pessoas_id">
                        <span class="error-label"></span>
                        <!-- deixar sem name para não fazer submit -->
                        <input class="form-elements" id="pessoas" data-target="pessoas_id">
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="quantidade">Quantidade</label>
                        <span class="error-label"></span>
                        <!-- deixar sem name para não fazer submit -->
                        <input class="form-elements" id="quantidade" data-target="quantidade">
                    </div>


                    <div class="" id="addPassageirosDiv" style="margin: 3px; padding:6px; border: 1px solid silver; ">
                        
                        <button class="btn btn-outline-secondary" id="copiarParaPassageiro" disabled="" style="display: none;">Copiar dados do cliente</button>
                        
                        <div class="" id="addPassageiroDiv">
                        </div>
                        <button class="btn btn-outline-secondary" id="btdAddPassageiro"><i class="fas fa-plus"></i> Adicionar passageiro</button>
                    </div>

                    <div class="" id="buscarViagensDiv" style="margin: 3px; padding:6px; border: 1px solid silver;">
                        <label>Buscar viagem</label>
                        <div class="conteudo">
                            <div class="form-group">
                                <label class="control-label mb-1" for="origem">Origem</label>
                                <input type="hidden" id="origem_id">
                                <span class="error-label"></span>
                                <!-- deixar sem name para não fazer submit -->
                                <input class="form-elements cidadeAutocomplete" id="origem" data-target="origem_id">
                            </div>
                            <div class="form-group">
                                <label class="control-label mb-1" for="destino">Destino</label>
                                <input type="hidden" id="destino_id">
                                <span class="error-label"></span>
                                <!-- deixar sem name para não fazer submit -->
                                <input class="form-elements cidadeAutocomplete" id="destino" data-target="destino_id">
                            </div>

                            <div class="form-group" style="display: flex;  align-items: end;  align-content: baseline;  justify-content: space-between;  width: max-content;">
                                <div style="width:45%;">
                                    <label class="control-label mb-1" for="data">Data</label>
                                    <input type="text" class="form-control datas" id="data_saida_ini" />
                                    <span class="error-label"></span>
                                </div>
                                <div style="width:10%; text-align: center;">a</div>
                                <div style="width:45%;">
                                    <label class="control-label mb-1" for="data">Data</label>
                                    <input type="text" class="form-control datas" id="data_saida_fim" />
                                    <span class="error-label"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <button class="btn btn-outline-secondary" id="btnLocalizarViagem" title="Localizar trecho"><i class="fas fa-search"></i> Buscar viagens</button>

                                <input type="hidden" id="trechos_id" name="trechos_id" />
                                <input type="hidden" id="viagens_id" name="viagens_id" />
                                <input type="hidden" id="linhas_id" name="linhas_id" />
                            </div>
                            <div id="trecho_info" style="border:0; padding: 8px;"></div>
                        </div>
                    </div>
                    <span class="btn btn-outline-primary" id="btnAlterarViagem">Alterar viagem</span>



                    <!-- <div class="form-group">
                        <label class="control-label mb-1" for="assento">Assento</label>
                        <span class="error-label"></span>
                        <input type="text" class="form-elements" id="assento" name="assento" value="" placeholder="Assento" />
                    </div> -->

                    <div class="form-group">
                        <label class="control-label mb-1" for="status">Status</label>
                        <span class="error-label"></span>
                        <select type="text" class="form-elements" id="status" name="status">
                            <option value="0">Selecione...</option>
                            <?php foreach ($listStatus->data as $st) : ?>
                                <option value="<?= $st->status ?>"><?= $st->descricao ?></option>
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
    jQuery('#valor').mask("#.##0,00", {
        reverse: true
    });

    jQuery(".datas").mask('00/00/0000 00:00');
    jQuery("#cpf").mask('000.000.000-00');
    jQuery("#celular").mask('00 00000-0000');

    jQuery(".datas").datetimepicker({
        format: "DD/MM/YYYY"
    });

    jQuery('#veiculos_id').select2({
        dropdownParent: jQuery('#formPedidoModal'),
    });
    jQuery('#status').select2({
        dropdownParent: jQuery('#formPedidoModal'),
    });

    $("#btnAlterarViagem").click(function() {
        $('#buscarViagensDiv').toggle('slow');
    })

    
    $("#copiarParaPassageiro").click(function(e) {
        e.preventDefault();
        var pessoas_id = $("#pessoas_id").val();
        if (pessoas_id > 0) {
            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('pessoas/listar') ?>',
                data: {
                    pessoas_id: pessoas_id
                },
                dataType: 'json',
                beforeSend: function() {},
                success: function(retorno) {
                    var dadosPreenchidos = false;
                    if (retorno.status == true) {
                        if (retorno.data.length) {
                            index = $(".addPassageirosGroup").length;

                            $("#addPassageirosDiv").show('slow');

                            var pessoas = retorno.data[0];
                                console.log('pessoas', pessoas);
                                $("#addPassageiroDiv").prepend(
                                    '<div class="conteudo addPassageirosGroup" data-index="' + index + '">' +
                                    '    <div><label>Dados do passageiro</label> <i class="far fa-trash-alt excluirPassageiro pointer" title="Excluir passageiros" style="margin-left:24px;"></i></div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="nome">Nome</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="nome' + index + '" name="passageiros[' + index + '][nome]" value="' + (pessoas.nome ?? '') + '" placeholder="Nome" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="cpf">CPF</label>' +
                                    '        <input type="text" class="form-elements" id="cpf' + index + '" name="passageiros[' + index + '][cpf]" value="' + (pessoas.cpf ?? '') + '" placeholder="CPF" />' +
                                    '        <span class="error-label"></span>' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="rg">RG</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="rg' + index + '" name="passageiros[' + index + '][rg]" value="' + (pessoas.rg ?? '') + '" placeholder="RG" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="celular">Celular</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="celular' + index + '" name="passageiros[' + index + '][celular]" value="' + (pessoas.celular ?? '') + '" placeholder="Celular" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="email">E-mail</label>' +
                                    '        <input type="text" class="form-elements" id="emai' + index + 'l" name="passageiros[' + index + '][email]" value="' + (pessoas.email ?? '') + '" placeholder="E-mail" />' +
                                    '        <span class="error-label"></span>' +
                                    '    </div>' +
                                    '</div>'
                                );
                            
                            jQuery("#cpf").mask('000.000.000-00');
                            jQuery("#celular").mask('00 00000-0000');

                            $(".excluirPassageiro").click(function(e){
                                $(this).parents('.addPassageirosGroup').remove();
                            })
                        }
                    } else {

                    }
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {}
            });
        } else {
            show_message("Por favor, informe o cliente para pode copiar os dados", 'warning')
        }
    });

    jQuery(".editar").click(function() {
        var este = jQuery(this);

        if($(this).attr('id') == 'btnAdicionarPedido'){
            $("#copiarParaPassageiro").prop('disabled', false).show();
        } else{
            $("#copiarParaPassageiro").prop('disabled', true).hide();
        }
        $("#addPassageiroDiv").html('');

        var trechos_id = este.data('trechos_id');
        var linhas_id = este.data('linhas_id');
        var viagens_id = este.data('viagens_id');
        console.log('linhas', linhas_id)
        if (linhas_id == '' || !linhas_id) {
            $("#buscarViagensDiv").show();
            $("#btnAlterarViagem").hide();
        } else {
            $("#buscarViagensDiv").hide();
            $("#btnAlterarViagem").show();
        }


        var trechosViagensEL = $('<div class="layout-dados" id="viagens-trechos_card' + 1 + '"></div>');
        if (linhas_id > 1) {
            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('viagens/listar') ?>',
                data: {
                    id: viagens_id
                },
                dataType: 'json',
                beforeSend: function() {
                    $("#trecho_info").html('<i class="fas fa-spinner fa-spin"></i> Aguarde...');
                },
                success: function(retorno) {
                    if (retorno.status == true) {
                        var viagem = retorno.data[0];
                        console.log(retorno);

                        trechosViagensEL.append(
                            '  <h5>Informações da viagem</h5>' +
                            '  <div class="layout-grid gap grid-3col">' +
                            '    <div>Descrição: ' + viagem.descricao + '</div>' +
                            '    <div>Detalhes: ' + viagem.detalhes + '</div>' +
                            '    <div>Data saída: ' + viagem.data_saidaFmt + '</div>' +
                            '    <div>Assentos: ' + viagem.assentos + '</div>' +
                            '    <div>Tipo de assento: ' + viagem.assentos_tipo + '</div>' +
                            '    <div>Código da viagem: ' + viagem.codigo + '</div>' +
                            '  </div>'
                        )

                    } else {}
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {}
            });

            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('trechos/listar') ?>',
                data: {
                    trechos_id: trechos_id,
                    linhas_id: linhas_id
                },
                dataType: 'json',
                beforeSend: function() {},
                success: function(retorno) {
                    if (retorno.status == true) {
                        var trecho = retorno.data[0];
                        trechosViagensEL.append(
                            '  <div>' +
                            '    <h5>Informações do trecho </h5>' +
                            '    <div class="layout-grid gap grid-2col">' +
                            '    <div>Linha: ' + trecho.linhas_descricao + '</div>' +
                            '    <div>Origem: ' + trecho.origem_cidade + ' (' + trecho.origem_sigla + ') - ' + trecho.origem_uf + ' ' + trecho.origem_endereco + '</div>' +
                            '    <div>Dias: ' + (trecho.diasSemanaTextBrev)?.join('; ') + '</div>' +
                            '    <div>Destino: ' + trecho.destino_cidade + ' (' + trecho.destino_sigla + ') - ' + trecho.destino_uf + ' ' + trecho.destino_endereco + '</div>' +
                            '    <div>Horário: ' + trecho.hora + '</div>' +
                            '    <div class="valores">Valor: ' + trecho.valor + '</div>' +
                            '  </div>'
                        );

                        console.log(retorno);
                    } else {}
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {}
            });
            $("#trecho_info").html(trechosViagensEL);

            $.ajax({
                type: 'POST',
                url: '<?= $this->siteUrl('passageiros/listar') ?>',
                data: {
                    pedidos_id: este.data('id')
                },
                dataType: 'json',
                beforeSend: function() {},
                success: function(retorno) {
                    if (retorno.status == true) {
                        if (retorno.data.length) {
                            index = 0;
                            $("#addPassageirosDiv").show('slow');
                            for (passageiro of retorno.data) {
                                console.log('passageiro', passageiro);
                                
                                $("#addPassageiroDiv").append(
                                    '<div class="conteudo addPassageirosGroup" data-index="' + index + '">' +
                                    '    <label>Dados do passageiro </label> <i class="far fa-trash-alt excluirPassageiro pointer" title="Excluir passageiros" style="margin-left:24px;"></i>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="nome">Nome</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="nome" name="passageiros[' + index + '][nome]" value="' + (passageiro.nome ?? '') + '" placeholder="Nome" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="cpf">CPF</label>' +
                                    '        <input type="text" class="form-elements" id="cpf" name="passageiros[' + index + '][cpf]" value="' + (passageiro.cpf ?? '') + '" placeholder="CPF" />' +
                                    '        <span class="error-label"></span>' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="rg">RG</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="rg" name="passageiros[' + index + '][rg]" value="' + (passageiro.rg ?? '') + '" placeholder="RG" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="celular">Celular</label>' +
                                    '        <span class="error-label"></span>' +
                                    '        <input type="text" class="form-elements" id="celular" name="passageiros[' + index + '][celular]" value="' + (passageiro.celular ?? '') + '" placeholder="Celular" />' +
                                    '    </div>' +
                                    '    <div class="form-group">' +
                                    '        <label class="control-label mb-1" for="email">E-mail</label>' +
                                    '        <input type="text" class="form-elements" id="email" name="passageiros[' + index + '][email]" value="' + (passageiro.email ?? '') + '" placeholder="E-mail" />' +
                                    '        <span class="error-label"></span>' +
                                    '    </div>' +
                                    '</div>'
                                );
                                index++;
                            }
                            jQuery("#cpf").mask('000.000.000-00');
                            jQuery("#celular").mask('00 00000-0000');

                            $(".excluirPassageiro").click(function(e){
                                $(this).parents('.addPassageirosGroup').remove();
                            })
                        }
                    } else {

                    }
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                },
                complete: function() {}
            });
        }

        jQuery("#pedidos_id").val(este.data('id'));
        jQuery("#pessoas_id").val(este.data('pessoas_id'));
        jQuery("#pessoas").val((este.data('pessoas_nome') ? este.data('pessoas_nome') + ' - ' + (este.data('pessoas_cpf') ?? '') : ''));
        jQuery("#viagens_id").val(este.data('viagens_id'));
        jQuery("#status").val(este.data('status')).trigger('change')
        //jQuery("#assento").val(este.data('assento'));
        jQuery("#valor").val(este.data('valor')?.replace('.', ',')).mask("#.##0,00", {
            reverse: true
        });


        jQuery("#formPedidoModalLabel").html('Pedido ' + (este.data('codigo') ? este.data('codigo') : ''));

        jQuery("#formPedidoModal").modal("show");
        jQuery(".cidadeAutocomplete").keyup(function() {
            autocompleteLocais($(this), "/locais/listar");
        });

    });


    $("#btnLocalizarViagem").click(function(evt) {
        evt.preventDefault();
        var origem_id = $("#origem_id").val();
        var destino_id = $("#destino_id").val();
        var data_saida_ini = $("#data_saida_ini").val();
        var data_saida_fim = $("#data_saida_fim").val();

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('viagens/procurar') ?>',
            data: {
                origem_id: origem_id,
                destino_id: destino_id,
                data_saida_ini: data_saida_ini,
                data_saida_fim: data_saida_fim
            },
            dataType: 'json',
            beforeSend: function() {
                $("#trecho_info").html('<i class="fas fa-spinner fa-spin"></i> Aguarde...');
            },
            success: function(retorno) {
                console.log('btnLocalizarTrecho -> retorno', retorno);
                var cardDados;
                if (retorno.status == true) {

                    $("#trecho_info").html('<h5>' + retorno.msg + '</h5>')
                    let viagem, trecho;
                    for (let key in retorno.data) {
                        console.log(key + ' => ' + retorno.data[key])
                        viagem = retorno.data[key].viagem;
                        trecho = retorno.data[key].trecho;
                        pontos = retorno.data[key].pontos;
                        cardDados = $('<div class="layout-dados" id="viagens-trechos_card' + key + '">');
                        cardDados.append(
                            '  <input type="radio" class="viagens-trechos_radios" id="radio_id' + key + '" name="viagens-trechos_id" data-id="' + key + '" data-viagens_id="' + viagem.id + '" data-trechos_id="' + trecho.trechos_id + '" data-linhas_id="' + trecho.linhas_id + '" />' +
                            '  <label for="radio_id' + key + '" style="display: inline-block;">Selecionar esta viagem</label>' +
                            '  <div style="margin-bottom: 15px;">'+
                            '    <h5>Informações da viagem</h5>' +
                            '    <div class="layout-grid gap grid-3col">' +
                            '      <div>Descrição: ' + viagem.descricao + '</div>' +
                            '      <div>Detalhes: ' + viagem.detalhes + '</div>' +
                            '      <div>Data saída: ' + viagem.data_saidaFmt + '</div>' +
                            '      <div>Assentos: ' + viagem.assentos + '</div>' +
                            '      <div>Tipo de assento: ' + viagem.assentos_tipo + '</div>' +
                            '      <div>Código da viagem: ' + viagem.codigo + '</div>' +
                            '    </div>' +
                            '  </div>' +
                            '  <div style="margin-bottom: 15px;">' +
                            '    <h5>Informações do trecho</h5>' +
                            '    <div class="layout-grid gap grid-2col">' +
                            '    <div>Linha: ' + trecho.linhas_descricao + '</div>' +
                            '    <div>Origem: ' + trecho.origem_cidade + ' (' + trecho.origem_sigla + ') - ' + trecho.origem_uf + ' ' + trecho.origem_endereco + '</div>' +
                            '    <div>Dias: ' + (trecho.diasSemanaTextBrev ? (trecho.diasSemanaTextBrev).join('; '):'') + '</div>' +
                            '    <div>Destino: ' + trecho.destino_cidade + ' (' + trecho.destino_sigla + ') - ' + trecho.destino_uf + ' ' + trecho.destino_endereco + '</div>' +
                            '    <div>Horário: ' + (trecho.hora??'') + '</div>' +
                            '    <div>Valor: <span class="valores">' + trecho.valor + '</span></div>' +
                            '  </div>' 
                        );

                        if(pontos.length){
                            cardPontos = $(
                                '    <div style="margin-bottom: 15px;">'
                                );
                                cardPontos.append('      <h5>Informações dos pontos</h5>');
                            for(let ponto of pontos){
                                cardPontos.append(
                                '  <div style="margin-bottom: 6px;">' +
                                    ponto.hora +' - '+ponto.cidade + ' (' + ponto.sigla + ') - ' + ponto.uf+
                                '  </div>'
                                );
                                
                            }
                            cardDados.append(cardPontos);
                        } 
                        $("#trecho_info").append(cardDados);
                    }
                    $(".viagens-trechos_radios").change(function() {

                        var viagens_id = $(this).data('viagens_id');
                        var trechos_id = $(this).data('trechos_id');
                        var linhas_id = $(this).data('linhas_id');
                        $("#viagens_id").val(viagens_id);
                        $("#trechos_id").val(trechos_id);
                        $("#linhas_id").val(linhas_id);
                        $(".viagens-trechos_radios").each(function(c, v) {
                            var $id = $(this).data('id');
                            console.log($(this));
                            if ($(this).is(":checked")) {
                                $("#viagens-trechos_card" + $id).css('outline', '2px solid #2ec8f7');
                            } else {
                                $("#viagens-trechos_card" + $id).css('outline', '1px solid silver');
                            }

                        })

                    });
                } else {
                    $("#trechos_id").val('');
                    $("#trecho_info").html('')
                    show_message(retorno.msg, 'danger');
                    if (retorno.data) {
                        for (var key in retorno.data) {
                            console.log('key', key)
                            $("#" + key).addClassTemp('form-elements-error');
                        }
                    }
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            },
            complete: function() {
                
                $('.valores').mask("Valor: #.##0,00", {
                    reverse: true
                });
            }
        });
    });

    $("#outro").change(function() {
        if ($(this).is(":checked")) {
            $("#addPassageirosDiv").show('slow');
        } else {
            $("#addPassageirosDiv").hide('slow');
        }
    });

    $("#btdAddPassageiro").click(function(evt) {
        evt.preventDefault()
        var index = 0;
        var lastGroup = $('.addPassageirosGroup').slice(-1);
        if (lastGroup.length) {
            index = $(lastGroup).data('index');
            index++;
        }

        $("#addPassageiroDiv").append(
            '<div class="conteudo addPassageirosGroup" data-index="' + index + '">' +
            '    <div><label>Dados do passageiro</label> <i class="far fa-trash-alt excluirPassageiro pointer" title="Excluir passageiros" style="margin-left:24px;"></i></div>' +
            '    <div class="form-group">' +
            '        <label class="control-label mb-1" for="nome">Nome</label>' +
            '        <span class="error-label"></span>' +
            '        <input type="text" class="form-elements" id="nome' + index + '" name="passageiros[' + index + '][nome]" value="" placeholder="Nome" />' +
            '    </div>' +
            '    <div class="form-group">' +
            '        <label class="control-label mb-1" for="cpf">CPF</label>' +
            '        <input type="text" class="form-elements" id="cpf' + index + '" name="passageiros[' + index + '][cpf]" value="" placeholder="CPF" />' +
            '        <span class="error-label"></span>' +
            '    </div>' +
            '    <div class="form-group">' +
            '        <label class="control-label mb-1" for="rg">RG</label>' +
            '        <span class="error-label"></span>' +
            '        <input type="text" class="form-elements" id="rg' + index + '" name="passageiros[' + index + '][rg]" value="" placeholder="RG" />' +
            '    </div>' +
            '    <div class="form-group">' +
            '        <label class="control-label mb-1" for="celular">Celular</label>' +
            '        <span class="error-label"></span>' +
            '        <input type="text" class="form-elements" id="celular' + index + '" name="passageiros[' + index + '][celular]" value="" placeholder="Celular" />' +
            '    </div>' +
            '    <div class="form-group">' +
            '        <label class="control-label mb-1" for="email">E-mail</label>' +
            '        <input type="text" class="form-elements" id="email' + index + '" name="passageiros[' + index + '][email]" value="" placeholder="E-mail" />' +
            '        <span class="error-label"></span>' +
            '    </div>' +
            '</div>'
        );
        $(".excluirPassageiro").click(function(e){
            $(this).parents('.addPassageirosGroup').remove();
        })
    });

    $("#passageiros").change(function(evt) {
        if ($(this).val() == '') {
            $("#pessoas_id").val('')
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
                    jQuery("#label_pessoas_nome" + id).html(retorno.data[0].pessoas_nome);
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

    $("body").on('keyup', '#pessoas', function(evt) {

        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 65 && event.keyCode <= 90)) {

            autocompletePessoas($(this));
        }
    })
</script>