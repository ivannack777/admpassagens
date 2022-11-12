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
                    <li class="active"><a href="<?= $this->siteUrl('pedidos/status') ?>"><i class="fas fa-cog"></i> Status</a></li>
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
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar" id="btnAdicionarPedido" title="Adicionar status"><i class="fas fa-plus"></i> Adicionar status</button>
                        <?php endif ?>
                    </div>
                    <div class="btn-toolbar" role="toolbar" aria-label="Toolbar with button groups">
                        <div class="btn-group mr-3" data-toggle="buttons" aria-label="First group">

                        </div>
                    </div>
                </div>

                <table id="bootstrap-data-table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="bootstrap-data-table_info">
                    <thead>
                        <tr>
                            <th>Sigla</th>
                            <th>Descricao</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($listStatus->data as $st) : ?>
                            <!-- informações da viagem -->
                            <tr id="linha<?= $st->status ?>">
                                <td><?= $st->status ?></td>
                                <td><?= $st->descricao ?></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $st->id ?>" data-status="<?= $st->status ?>" data-descricao="<?= $st->descricao ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                </td>
                            </tr>


                        <?php endforeach ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div> <!-- .content -->

<div class="modal fade" id="formPedido_statusModal" tabindex="-1" role="dialog" aria-labelledby="formPedido_statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="formPedido_statusModalLabel">Pedido</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formViagem">
                    <div class="form-group">
                        <input type="hidden" id="id" name="id">
                        <label class="control-label mb-1" for="status">Sigla</label>
                        <input type="text" class="form-elements" id="status" name="status" maxlength="1" placeholder="Sigla" style="text-transform: uppercase;">
                        <span class="error-label"></span>
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="descricao">Descrição</label>
                        <input type="text" class="form-elements" id="descricao" name="descricao" placeholder="Descrição">
                        <span class="error-label"></span>
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
    

    $(".editar").click(function() {
        var este = $(this);


        $("#id").val(este.data('id'));
        $("#status").val(este.data('status'));
        $("#descricao").val(este.data('descricao'));
        $("#formPedido_statusModalLabel").html('Status ' + (este.data('status') ? este.data('status') +' '+ este.data('descricao') : ''));
        $("#formPedido_statusModal").modal("show");

    });


    $("#btnSalvar").click(function() {
        var este = $(this);
        var id = $("#id").val();
        var form = $("#formViagem");

        $.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('pedidos/status/salvar/') ?>'+id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {
                $('.error-label').html('');
            },
            success: function(retorno) {
                if (retorno.status == true) {
                    show_message(retorno.msg, 'success', null, '/pedidos/status');
                    $("#linha" + id).addClass('success-transition');
                } else {
                    $("#linha" + id).addClass('error-transition');
                    show_message(retorno.msg, 'danger');
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
        var id = $("#pedidos_id").val();
        var rota = '<?= $this->siteUrl('pedidos_status/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('pedidos') ?>';
        excluir(rota, 'Você realmente quer excluir este pedido?', redirect);
    });

</script>