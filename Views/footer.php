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

    function show_message(texto,classe='info', interval=null, redirect=null){
        
        if(interval === null){
            interval = texto.length;
        }

        carregando('hidden');
        if (timerMensagem !== 0) {
            clearInterval(timerMensagem);
        }

        jQuery("#msgfloat").removeClass().addClass('alert alert-'+classe);
        jQuery("#msgfloat_text").html(texto);

        var bodyCenter = jQuery("body").width()/2;
        var msgfloatCenter = jQuery("#msgfloat").outerWidth()/2;
        var msgfloatPosition = bodyCenter - msgfloatCenter;

        jQuery("#msgfloat").css('display', 'block');
        jQuery("#msgfloat").css('left', msgfloatPosition +'px');
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
                if(redirect !== null){
                    window.location.href= redirect;
                }
            
            }
        }, interval);
        
    }

    jQuery("#msgfloat_btn").click(function(){
        jQuery("#msgfloat").css('display', 'none');
        clearInterval(timerMensagem);
    });

    function carregando(visao){
        if(visao == 'show') visible = 'visible';
        else visible = 'hidden'
        jQuery("#progressgif").css('visibility', visible);
    }
    
    function excluir(rota, msg, redirect){
        var confirmar = confirm(msg);
        var retornoExcluir = false;

        if(confirmar){
            jQuery.ajax({
                type: 'POST',
                url: rota,
                data: {},
                dataType: 'json',
                beforeSend: function() {
                    
                },
                success: function(retorno) {
                    if(retorno.status){
                        show_message(retorno.msg, 'success', null, redirect);
                        retornoExcluir = true;
                    } else{
                        show_message(retorno.msg, 'danger');
                    }
                },
                error: function(st) {
                    show_message(st.status + ' ' + st.statusText, 'danger');
                }
            });
        }
        
    }
    </script>

    
</body>
</html>