<div style="display: flex;">

    <div style="margin:12px 8px;">
        <h5><?= ($comentarios->count < 1 ? 'Nenhum comentários' : ($comentarios->count > 1 ? $comentarios->count . ' comentários' : '1 comentário')) ?> deste item</h5>
    </div>
    <div id="comentariosModatextoPostitle" style="margin:12px 8px;">
        <!-- aqui vai aparece o spinner -->
    </div>
</div>
<div>
    <div class="d-grid gap-3">
        <?php foreach ($comentarios->data as $comentario) : ?>
            <div class="d-grid gap-3">

                <div class="p-2 bg-light border" id="comentarioId<?= $comentario->id ?>">
                    <div class="">
                        Por <span class="font-18 card-title"><?= $comentario->usuario ?></h5>
                    </div>
                    <div class="layout-flex flex-row flex-between">
                        <p class="" style="margin: 12px;"><?= $comentario->texto ?></p>
                    </div>
                    <div class="layout-flex flex-row flex-between">
                        <h6 class="card-subtitle mb-2 text-muted"><?= $this->dateFormat($comentario->data_insert) ?></h6>
                        <a href="#" class="card-link comentariosExcluir text-danger" data-codigo="<?= $comentario->id ?>">Excluir</a>
                    </div>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>