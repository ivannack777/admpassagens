<div style="display: flex;">

    <div style="margin:12px 8px;">
        <h5><?=  ($comentarios->count < 1 ? 'Nenhum comentários' : ($comentarios->count > 1 ? $comentarios->count . ' comentários': '1 comentário')) ?> deste item</h5>
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
                    <h5 class="card-title"><?= $comentario->usuario ?></h5>
                    <h6 class="card-subtitle mb-2 text-muted"><?= $comentario->data_insert ?></h6>
                    <p class="card-text"><?= $comentario->texto ?></p>
                    <a href="#" class="card-link comentariosExcluir text-danger" data-codigo="<?= $comentario->id ?>">Excluir</a>
                </div>
            </div>
        <?php endforeach ?>

    </div>
</div>
