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
                        <h4 class="card-title mb-0">Usuários</h4>
                        <div class="small text-muted"><?= $usuarios->count() ?> usuarios estão sendo exibidos></div>
                    </div>
                    <div class="">
                        <?php $session = $this->getAttributes();
                        $usersession = $session['userSession'] ?? false;
                        if ($usersession && $usersession['nivel'] >= 3) : ?>
                            <button type="button" class="btn btn-primary bg-flat-color-1 editar"><i class="fas fa-plus"></i> Adicionar usuário</button>
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
                            <th>Usuário</th>
                            <th>E-mail</th>
                            <th>Celular</th>
                            <th>Pessoa</th>
                            <th>Nível</th>
                            <th><i class="fas fa-cog"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario) :
                        ?>
                            <tr id="linha<?= $usuario->id ?>" class="list-label">
                                <td><span id="label_usuario<?= $usuario->id ?>"><?= $usuario->usuario ?></span></td>
                                <td><span id="label_email<?= $usuario->id ?>"><?= $usuario->email ?> </span></td>
                                <td><span id="label_celular<?= $usuario->id ?>" class="label_celular"><?= $usuario->celular ?> </span></td>
                                <td><span id="label_pessoas_id<?= $usuario->id ?>"><?= $usuario->pessoas_id ?></span></td>
                                <td><span id="label_nivel<?= $usuario->id ?>"><?= $usuario->nivel ?></span></td>
                                <td>
                                    <?php $session = $this->getAttributes();
                                    $usersession = $session['userSession'] ?? false;
                                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                                    <!-- Editar -->
                                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $usuario->id ?>" data-usuario="<?= $usuario->usuario ?>" data-email="<?= $usuario->email ?>" data-celular="<?= $usuario->celular ?>" data-pessoas_id="<?= $usuario->pessoas_id ?>" data-nivel="<?= $usuario->nivel ?>">
                                            </i>Editar</button>
                                    <?php endif ?>
                                    <!-- Favoritar -->
                                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" 
                                    data-item="usuarios" data-item_id="<?= $usuario->id ?>" 
                                        >
                                        <?php if(isset($usuario->favoritos_id) && !empty($usuario->favoritos_id)): ?>
                                            <i class="fas fa-heart"></i> 
                                        <?php else: ?>
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
                <h5 class="modal-title" id="mediumModalLabel">Usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUsuario">
                    <input type="hidden" id="usuario_id" name="usuario_id" value="" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="usuario">Usuário</label>
                        <input type="text" class="form-elements" id="usuario" name="usuario" value="" />
                        <small class="form-text text-muted">ex. 99/99/9999</small>
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="email">E-mail</label>
                        <input type="text" class="form-elements" id="email" name="email" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="celular">Celular</label>

                        <input type="text" class="form-elements" id="celular" name="celular" value="" />
                    </div>

                    <div class="form-group">
                        <label class="control-label mb-1" for="nivel">Nível</label>
                        <select class="form-elements" id="nivel" name="nivel">
                            <option value="0">Selecione...</option>
                            <option value="1">1 - Básico</option>
                            <option value="3">3 - Médio</option>
                            <option value="5">5 - Super</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <div>
                    <?php $session = $this->getAttributes();
                    $usersession = $session['userSession'] ?? false;
                    if ($usersession && $usersession['nivel'] >= 5) : ?>
                        <button id="btnExcluir" class="btn btn-outline-danger" title="Excluir"><i class="fas fa-times"></i> Excluir</button>
                        <button class="btn btn-outline-warning chpass" title="Alterar senha" style="margin-right: 8px;" data-id="<?= $usuario->id ?>"><i class="fas fa-lock"></i> Alterar senha</button>
                    <?php endif ?>
                </div>
                <div>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnSalvar"><i class="fa fa-save salvar pointer"></i> Salvar</button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="formMediumModalChpass" tabindex="-1" role="dialog" aria-labelledby="smallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mediumModalLabel">Alterar senha</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formSenha">
                    <input type="hidden" id="senha_usuario_id" name="senha_usuario_id" value="" />

                    <div class="form-group">
                        <label class="control-label mb-1" for="usuario">Nova senha</label>
                        <input type="password" class="form-elements" id="senha" name="senha" value="" />
                    </div>
                    <div class="form-group">
                        <label class="control-label mb-1" for="resenha">Repetir nova senha</label>
                        <input type="password" class="form-elements" id="resenha" name="resenha" value="" />
                    </div>
                    <div class="form-group">
                        <div class="alert" id="chpassDiag"></div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="btnSalvarSenha"><i class="fa fa-save salvar pointer"></i> Salvar</button>
            </div>
        </div>
    </div>
</div>
<script>
    jQuery('.label_celular').mask('00 00000-0000');
    jQuery(".datas").datetimepicker({
        format: "d/m/Y H:i"
    });

    jQuery(".editar").click(function() {
        var este = jQuery(this);
        jQuery("#usuario_id").val(este.data('id'));

        if (este.data('pessoas_id')) {
            jQuery('#pessoas_id option[value="' + este.data('pessoas_id') + '"]').prop('selected', true);
        } else {
            jQuery('#pessoas_id option[value="0"]').prop('selected', true);
        }
        if (este.data('nivel')) {
            jQuery('#nivel option[value="' + este.data('nivel') + '"]').prop('selected', true);
        } else {
            jQuery('#nivel option[value="0"]').prop('selected', true);
        }

        jQuery("#usuario").val(este.data('usuario'));
        jQuery("#email").val(este.data('email'));
        jQuery("#celular").val(este.data('celular')).mask('00 00000-0000');
        jQuery("#mediumModalLabel").html('Usuário '+(este.data('usuario')?este.data('usuario'):''));
        jQuery("#formMediumModal").modal("show")
    });

    jQuery(".chpass").click(function() {
        var este = jQuery(this);
        var id = jQuery("#senha_usuario_id").val(este.data('id'));
        jQuery("#formMediumModalChpass").modal("show")
    });

    jQuery("#btnSalvar").click(function() {
        var este = jQuery(this);
        var id = jQuery("#usuario_id").val();
        var form = jQuery("#formUsuario");

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('usuarios/salvar/') ?>' + id,
            data: form.serialize(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(retorno) {
                jQuery("#formMediumModal").modal("hide")
                if (retorno.status == true) {
                    show_message(retorno.msg, 'success');
                    jQuery("#label_usuario" + id).html(retorno.data[0].usuario);
                    jQuery("#label_celular" + id).html(retorno.data[0].celular);
                    jQuery("#label_email" + id).html(retorno.data[0].email);
                    jQuery("#label_pessoas_id" + id).html(retorno.data[0].pessoas_id);
                    jQuery("#linha" + id).addClass('success-transition');
                } else {
                    jQuery("#linha" + id).addClass('error-transition');
                    show_message(retorno.msg, 'danger');
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    jQuery("#btnSalvarSenha").click(function() {
        var este = jQuery(this);
        var id = jQuery("#senha_usuario_id").val();
        var formSenha = jQuery("#formSenha");
        var senha = jQuery("#senha").val();
        var resenha = jQuery("#resenha").val();

        if (senha != resenha) {
            jQuery("#chpassDiag").html('As senhas não coincidem').removeClass().addClass('text-danger');
            return false;
        }

        jQuery.ajax({
            type: 'POST',
            url: '<?= $this->siteUrl('usuarios/salvar/') ?>' + id,
            data: formSenha.serialize(),
            dataType: 'json',
            beforeSend: function() {},
            success: function(retorno) {
                if (retorno.status == true) {
                    jQuery("#formMediumModalChpass").modal("hide")
                    show_message("Senha foi alterada", 'success');
                } else {
                    jQuery("#chpassDiag").html(retorno.msg).removeClass().addClass('text-danger');
                }
            },
            error: function(st) {
                show_message(st.status + ' ' + st.statusText, 'danger');
            }
        });
    });

    jQuery("#btnExcluir").click(function() {
        var id = jQuery("#usuario_id").val();
        var rota = '<?= $this->siteUrl('usuarios/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('usuarios') ?>';
        excluir(rota, 'Você realmente quer excluir este usuário?', redirect);
    });
</script>