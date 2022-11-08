<table id="bootstrap-data-table" class="table table-bordered dataTable no-footer" role="grid" aria-describedby="bootstrap-data-table_info">
    <thead>
        <tr>
            <td>Código</td>
            <td>Descrição</td>
            <td>Pedidos/Assentos</td>
            <td>Saída</td>
            <td>Chegada</td>
            <td>Valor</td>
            <td>Veículo</td>
            <td><i class="fas fa-cog"></i></td>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($viagens->data as $viagem) :
        ?>
            <tr id="linha<?= $viagem->id ?>" class="list-label">
                <td><span id="label_codigo<?= $viagem->id ?>"><?= $viagem->codigo ?>[<?= $viagem->id ?>]</span></td>
                <td><span id="label_descricao<?= $viagem->id ?>"><?= $viagem->descricao ?></span></td>
                <td>
                    <span id="label_pedidos<?= $viagem->id ?>">
                        <?= isset($pedidosCount[$viagem->id]) ? print_r($pedidosCount[$viagem->id]->count, true) : '0' ?>/<?= $viagem->assentos ?>
                        <a href="<?= $this->siteUrl('pedidos?viagens_key=' . $viagem->key) ?>" title="Ver pedidos dessa viagem">Ver pedidos</a>
                    </span>
                </td>
                <td><span id="label_data_saida<?= $viagem->id ?>"><?= $this->dateFormat($viagem->data_saida, 'd/m/Y H:i') ?></span></td>
                <td><span id="label_data_chegada<?= $viagem->id ?>"><?= $this->dateFormat($viagem->data_chegada, 'd/m/Y H:i') ?></span></td>
                <td><span id="label_valor<?= $viagem->id ?>"><?= str_replace('.', ',', $viagem->valor ?? '') ?></span></td>
                <td><span id="label_veiculos_id<?= $viagem->id ?>">
                        <?=
                        $viagem->marca . " " .
                            $viagem->modelo . " " .
                            $viagem->ano . " " .
                            $viagem->veiculos_codigo . " " .
                            $viagem->placa
                        ?>
                    </span>
                </td>
                <td>
                    <?php $session = $this->getAttributes();
                    $usersession = $session['userSession'] ?? false;
                    if ($usersession && $usersession['nivel'] >= 3) : ?>
                        <!-- Editar -->
                        <button class="btn btn-outline-primary btn-sm editar" title="Editar" style="margin-right: 8px;" data-id="<?= $viagem->id ?>" data-veiculos_id="<?= $viagem->veiculos_id ?>" data-descricao="<?= $viagem->descricao ?>" data-valor="<?= str_replace('.', ',', $viagem->valor ?? '') ?>" data-data_saida="<?= $this->dateFormat($viagem->data_saida, 'd/m/Y H:i') ?>" data-data_chegada="<?= $this->dateFormat($viagem->data_chegada, 'd/m/Y H:i') ?>" data-assentos="<?= $viagem->assentos ?>" data-assentos_tipo="<?= $viagem->assentos_tipo ?>" data-detalhes="<?= $viagem->detalhes ?>">
                            <i class="far fa-edit"></i> Editar</button>
                    <?php endif ?>
                    <!-- Favoritar -->
                    <button class="btn btn-outline-primary btn-sm btnFav" title="Favoritar" style="margin-right: 8px;" data-item="viagens" data-item_id="<?= $viagem->id ?>">
                        <?php if (isset($viagem->favoritos_id) && !empty($viagem->favoritos_id)) : ?>
                            <i class="fas fa-heart"></i>
                        <?php else : ?>
                            <i class="far fa-heart"></i>
                        <?php endif ?>
                    </button>
                    <button class="btn btn-outline-primary btn-sm btnComentario" title="Comentarios" style="margin-right: 8px;" data-item="viagens" data-item_id="<?= $viagem->id ?>" data-title="<?= $viagem->descricao ?>">
                        <i class="far fa-comment"></i>
                    </button>
                </td>
            </tr>

        <?php endforeach ?>
    </tbody>
</table>