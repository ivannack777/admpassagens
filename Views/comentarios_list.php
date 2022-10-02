<div style="margin:12px 8px;">
    <h5><?= count($comentarios) . (count($comentarios) > 1 ? ' comentários' : ' comentário') ?> deste item</h5>
</div>
<div>
    <div class="d-grid gap-3">
        <?php foreach ($comentarios as $comentario) : ?>
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
<script>
        jQuery(".comentariosExcluir").click(function() {
        var id = jQuery(this).data('codigo');
        var item = jQuery("#comentariosModalitem").val();
        var item_id = jQuery("#comentariosModalitem_id").val();
        var rota = '<?= $this->siteUrl('comentarios/excluir/') ?>' + id;
        var redirect = '<?= $this->siteUrl('viagens') ?>';
        excluir(rota, 'Você realmente quer excluir este comentário?', null);
        jQuery("#comentarioId"+id).hide('shlow');
        setTimeout(function(){
            showComentarios(item, item_id);
        }, 600);
        
    });

</script>