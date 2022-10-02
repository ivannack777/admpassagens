 </div><!-- fechamento de <div id="right-panel" class="right-panel"> aberto em right_top -->

 <div id="msgfloat" style="position: fixed; top: 10px; left: 749.867px; z-index: 2000; padding: 4px 12px; display: none">
     <div style="display: flex;flex-direction: row;justify-content: space-between;">
         <div id="msgfloat_text" style="border: 1px solid; height: 100%;text-align: center;vertical-align: middle;padding: 8px;"></div>
         <span id="msgfloat_btn" class="pointer" style="width: 10px; padding: 7px;color: #ddc4c4;"><i class="fas fa-times"></i></span>
     </div>
     <div class="divtable" style="height: 4px;display: flex;">
         <div id="progressoMsgFloat" style="height: 2px; width: 100%;"></div>
     </div>
 </div>



 <div class="modal fade"  id="comentariosModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">>
     <div class="modal-dialog modal-lg">
         <div class="modal-content">
             <div class="modal-header">
                 <h5 class="modal-title" id="comentariosModalLabel">Modal title</h5>
                 <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body">


                 
                 <div class="border-bottom" style="padding: 12px;">

                     <form id="comentariosModalForm">
                         <input type="hidden" name="item" id="comentariosModalitem">
                         <input type="hidden" name="item_id" id="comentariosModalitem_id">
                         <div class="mb-3">
                             <label class="form-label" for="comentariosModatexto">Envie seu comentário</label>
                             <textarea class="form-control" name="comentariosModatexto" id="comentariosModatexto"></textarea>
                         </div>
                     </form>
                     <div style="text-align: right;">
                         <button type="button" class="btn btn-secondary" onClick="jQuery('#comentariosModatexto').val('')">Limpar</button>
                         <button type="button" class="btn btn-primary" id="btnComentariosModalSalvar"><i class="fas fa-paper-plane"></i> Enviar</button>
                     </div>
                 </div>
             
                 <div id="comentariosModalBody"></div>
             </div>
             <div class="modal-footer">
             </div>
         </div>
     </div>
 </div>


 <script type="text/javascript">
     var timerMensagem;
     // (function($) {
     //     "use strict";

     //     jQuery('#vmap').vectorMap({
     //         map: 'world_en',
     //         backgroundColor: null,
     //         color: '#ffffff',
     //         hoverOpacity: 0.7,
     //         selectedColor: '#1de9b6',
     //         enableZoom: true,
     //         showTooltip: true,
     //         values: sample_data,
     //         scaleColors: ['#1de9b6', '#03a9f5'],
     //         normalizeFunction: 'polynomial'
     //     });
     // })(jQuery);

     function show_message(texto, classe = 'info', interval = null, redirect = null) {

         if (interval === null) {
             interval = texto.length;
         }

         carregando('hidden');
         if (timerMensagem !== 0) {
             clearInterval(timerMensagem);
         }

         jQuery("#msgfloat").removeClass().addClass('alert alert-' + classe);
         jQuery("#msgfloat_text").html(texto);

         var bodyCenter = jQuery("body").width() / 2;
         var msgfloatCenter = jQuery("#msgfloat").outerWidth() / 2;
         var msgfloatPosition = bodyCenter - msgfloatCenter;

         jQuery("#msgfloat").css('display', 'block');
         jQuery("#msgfloat").css('left', msgfloatPosition + 'px');
         jQuery("#progressoMsgFloat")
             .css({
                 "width": "100%",
                 "background-color": "#3C763D"
             })
             .data("value", 100);
         timerMensagem = setInterval(function() {
             jQuery("#progressoMsgFloat").data("value", jQuery("#progressoMsgFloat").data("value") - 1);
             jQuery("#progressoMsgFloat").css("width", jQuery("#progressoMsgFloat").data("value") + "%");

             //quando progressbar terminar
             if (jQuery("#progressoMsgFloat").data("value") <= 0) {
                 clearInterval(timerMensagem);
                 jQuery("#msgfloat").css('display', 'none');
                 if (redirect !== null) {
                     window.location.href = redirect;
                 }

             }
         }, interval);

     }

     jQuery("#msgfloat_btn").click(function() {
         jQuery("#msgfloat").css('display', 'none');
         clearInterval(timerMensagem);
     });

     function carregando(visao) {
         if (visao == 'show') visible = 'visible';
         else visible = 'hidden'
         jQuery("#progressgif").css('visibility', visible);
     }

     function excluir(rota, msg, redirect) {
         var confirmar = confirm(msg);
         var retornoExcluir = false;

         if (confirmar) {
             jQuery.ajax({
                 type: 'POST',
                 url: rota,
                 data: {},
                 dataType: 'json',
                 beforeSend: function() {

                 },
                 success: function(retorno) {
                     if (retorno.status) {
                         show_message(retorno.msg, 'success', null, redirect);
                         retornoExcluir = true;
                     } else {
                         show_message(retorno.msg, 'danger');
                     }
                 },
                 error: function(st) {
                     show_message(st.status + ' ' + st.statusText, 'danger');
                 }
             });
         }

     }

     jQuery(".btnFav").click(function() {
         var element = jQuery(this);

         var item = element.data('item');
         var item_id = element.data('item_id');

         jQuery.ajax({
             type: 'POST',
             url: '<?= $this->siteUrl('favoritos/salvar') ?>',
             data: {
                 item: item,
                 item_id: item_id
             },
             dataType: 'json',
             beforeSend: function() {
                 element.html('<i class="fas fa-spinner fa-spin"></i>');
             },
             success: function(retorno) {
                 if (retorno.status == true) {
                     if (retorno.data.resultado == 1) {
                         element.html('<i class="fas fa-heart"></i>');
                     } else {
                         element.html('<i class="far fa-heart"></i>');
                     }
                     // show_message(retorno.msg, 'success');


                 } else {
                     show_message(retorno.msg, 'danger');
                 }
             },
             error: function(st) {
                 show_message(st.status + ' ' + st.statusText, 'danger');
             }
         });
     });


     jQuery(".btnComentario").click(function() {
        
         var element = jQuery(this);
         var item = element.data('item');
         var item_id = element.data('item_id');
         var title = element.data('title');

         jQuery("#comentariosModalitem").val(item);
         jQuery("#comentariosModalitem_id").val(item_id);
         
         showComentarios(item, item_id)
         jQuery("#comentariosModalLabel").html(title);
         jQuery("#comentariosModal").modal('show');
     });

     function showComentarios(item, item_id) {
        console.log('item item_id',item, item_id);
         jQuery.ajax({
             type: 'POST',
             url: '<?= $this->siteUrl('comentarios/ver') ?>',
             data: {
                 item: item,
                 item_id: item_id
             },
             dataType: 'html',
             beforeSend: function() {
                //  element.html('<i class="fas fa-spinner fa-spin"></i>');
             },
             success: function(retorno) {
                console.log(jQuery("#comentariosModalBody"));
                 jQuery("#comentariosModalBody").html(retorno);
             },
             error: function(st) {
                 show_message(st.status + ' ' + st.statusText, 'danger');
             },
             complete: function() {
                //  element.html('<i class="far fa-comment"></i>');
             }
         });
     }


     jQuery("#btnComentariosModalSalvar").click(function() {
         var element = jQuery(this);

         var item = jQuery("#comentariosModalitem").val();
         var item_id = jQuery("#comentariosModalitem_id").val();
         var texto = jQuery('#comentariosModatexto').val();

         jQuery.ajax({
             type: 'POST',
             url: '<?= $this->siteUrl('comentarios/salvar') ?>',
             data: {
                 item: item,
                 item_id: item_id,
                 texto: texto
             },
             dataType: 'json',
             beforeSend: function() {
                 element.html('<i class="fas fa-spinner fa-spin"></i>');
             },
             success: function(retorno) {
                 if (retorno.status == true) {
                    jQuery('#comentariosModatexto').val('');
                     showComentarios(item, item_id);
                 } else {
                     show_message(retorno.msg, 'danger');
                 }
             },
             error: function(st) {
                 show_message(st.status + ' ' + st.statusText, 'danger');
             },
             complete: function() {
                 element.html('<i class="far fa-paper-plane"></i> Enviar');
             }
         });
     });



 </script>


 </body>

 </html>