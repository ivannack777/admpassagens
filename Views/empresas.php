<div class="breadcrumbs">
    <div class="col-sm-4">
        <div class="page-header float-left">
            <div class="page-title">
                <ul class="breadcrumb">
                    <li class="breadcrumb-item active page-title">Empresas</li>
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
                <div class="flex-row flex-between">
                    <div class="">
                        <h4 class="card-title mb-0">Empresas</h4>
                        <div class="small text-muted"><?= $empresas->count() ?> empresas estão sendo exibidas</div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar empresa</button>
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
                            <th>Nome</th>
                            <th>CNPJ</th>
                            <th>Cidade</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($empresas as $empresa) :
                        ?>
                            <tr id="linha<?= $empresa->id ?>" class="list-label">
                                <td><span id="label_nome<?= $empresa->id ?>"><?= $empresa->nome ?></span></td>
                                <td><span id="cnpj<?= $empresa->id ?>" class="label_cnpj"><?= $empresa->cnpj ?></span></td>
                                <td><span id="cidade<?= $empresa->id ?>"><?= $empresa->cidade . ' - ' . $empresa->uf ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                        <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $empresa->id ?>" data-nome="<?= $empresa->nome ?>" data-cnpj="<?= $empresa->cnpj ?>" data-cep="<?= $empresa->cep ?>" data-logradouro="<?= $empresa->logradouro ?>" data-numero="<?= $empresa->numero ?>" data-bairro="<?= $empresa->bairro ?>" data-uf="<?= $empresa->uf ?>" data-cidade="<?= $empresa->cidade ?>">
                                            <i class="far fa-edit"></i> Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" 
                                    data-item="empresas"
                                    data-item_id="<?= $empresa->id ?>">
                                        <?php if (isset($empresa->favoritos_id) && !empty($empresa->favoritos_id)) : ?>
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
                <h5 class="modal-title" id="mediumModalLabel">Veículo</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formempresa">
                    <input type="hidden" id="empresa_id" name="empresa_id" value="" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="nome">Nome</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="nome" name="nome" value="" />
                        <small class="form-text text-muted">ex. Nome da Empresa S.A.</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="cnpj">CNPJ</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="cnpj" name="cnpj" value="" placeholder="__.___.___/____-__" />
                        <small class="form-text text-muted">ex. 12.345.678/0001-90</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="cep">CEP</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="cep" name="cep" value="" placeholder="_____-___" />
                        <small class="form-text text-muted">ex. 12345-678</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="logradouro">Logradouro</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="logradouro" name="logradouro" value="" placeholder="Logradouro" />
                        <small class="form-text text-muted">ex. Av. Brasil</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="numero">Número</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="numero" name="numero" value="" placeholder="Número" />
                        <small class="form-text text-muted">ex. 123</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="bairro">Bairro</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="bairro" name="bairro" value="" placeholder="Bairro" />
                        <small class="form-text text-muted">ex. 123</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="uf">Estado</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="uf" name="uf" value="" placeholder="__" style="text-transform: uppercase;" />
                        <small class="form-text text-muted">ex. AM</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="cidade">Cidade</label>
                        <span class="text-danger error-label"></span>
                        <input type="text" class="form-elements" id="cidade" name="cidade" value="" placeholder="Cidade" />
                        <small class="form-text text-muted">ex. Rincão</small>
                    </div>
                    <?php $session = $this->getAttributes();
                    $usersession = $session['userSession'] ?? false;
                    if ($usersession && $usersession['nivel'] >= 5) : ?>
                        <div class="form-group">
                            <label class="control-label mb-1" for="usuarios_id">Usuário</label>
                            <span class="text-danger error-label"></span>
                            <select class="form-elements" id="usuarios_id" name="usuarios_id">
                                <option>Selecione...</option>

                            </select>
                        </div>
                    <?php endif ?>
                </form>
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
    jQuery('.label_cnpj').mask('00.000.000/0000-00');

    jQuery(".editar").click(function() {
        var este = jQuery(this);

        jQuery("#empresa_id").val(este.data('id'));
        jQuery("#nome").val(este.data('nome'));
        jQuery("#cnpj").val(este.data('cnpj')).mask('00.000.000/0000-00');
        jQuery("#cep").val(este.data('cep')).mask('00000-000');
        jQuery("#logradouro").val(este.data('logradouro'));
        jQuery("#numero").val(este.data('numero'));
        jQuery("#bairro").val(este.data('bairro'));
        jQuery("#uf").val(este.data('uf')).mask('AA', {
            'translation': {
                A: {
                    pattern: /[A-Za-z]/
                }
            }
        });
        jQuery("#cidade").val(este.data('cidade'));
        jQuery("#mediumModalLabel").html('Empresa ' + (este.data('nome') ? este.data('nome') : ''));
        jQuery("#formMediumModal").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var id = jQuery("#empresa_id").val();
        var form = jQuery("#formempresa");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('empresas/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(retorno) {
                if (retorno.status == true) {
                    jQuery("#formMediumModal").modal("hide");
                    show_message(retorno.msg, 'success');

                    jQuery("#label_nome" + id).html(retorno.data[0].nome);
                    jQuery("#label_cnpj" + id).html(retorno.data[0].cnpj);
                    jQuery("#label_cidade" + id).html(retorno.data[0].cidade + ' - ' + retorno.data[0].uf);
                    jQuery("#linha" + id).addClass('success-transition');
                    show_message(retorno.msg, 'success');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    jQuery("#btnExcluir").click(function() {
        var id = jQuery("#empresa_id").val();
        var rota = '<?= $this->siteUrl('empresas/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('empresas') ?>';
        excluir(rota, 'Você realmente quer excluir esta empresa?', redirect);
    });
</script>