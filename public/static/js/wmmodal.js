window.WmModal = (function(){

    var defaultElements = {
        modal       : '.wm-modal',
        title       : '.wm-modal-title',
        box         : '.wm-modal-box',
        body        : '.wm-modal-body',
        btnCancel   : '.wm-modal-btn-cancel',
        close       : '.wm-modal-close',
        btnConfirm  : '.wm-modal-btn-confirm',
        inputPrompt : '.wm-input-prompt'
    };


    var defaultsSettings = {
        height      : 300,
        width       : 300,
        title       : '',
        content     : '',
        type        : 'alert',
        onCancel    : function(){},
        /**
           * No caso de input "prompt", é possível passar o parâmetro "value"
        **/
        onConfirm   : function(){},
        onOpen      : function(){},        
    };

    statics = {
        priority    : 10,
        effectsShow     : ['fadeIn', 'show', 'slideDown', 'animate'],
        include : function(url) {
            xhr = new XMLHttpRequest();
            xhr.open('GET', url, false);
            xhr.send();
            return this.cachedInclude = xhr.responseText;
        },

    };
    
    $('<link />', {
        href: '/static/css/wmmodal.css',
        rel: 'stylesheet',
        type: 'text/css'
    }).appendTo('head');


    return function (modalSelector, options) {

        options = options || {};
        
        
        if (modalSelector === null) {
            if (!statics.cachedInclude) {
                modalSelector = statics.include(options.modalTemplate || '/static/js/wmmodal.tpl');
            } else {
                modalSelector = statics.cachedInclude;
            }
        }
               
        
        var $instance   = $(modalSelector).first().clone().hide(),
            settings    = $.extend({}, defaultsSettings, options),
            elements    = $.extend({}, defaultElements, options.elements),
            $body       = $instance.find(elements.body),
            $btnConfirm = $instance.find(elements.btnConfirm),
            $linkClose  = $instance.find(elements.close),
            $btnCancel  = $instance.find(elements.btnCancel);


        var defineModalType = function () {
            switch (settings.type) {
                case 'alert':
                    defaultsSettings.title = 'Alerta'
                    $btnConfirm.remove();
                    break;
                case 'confirm':
                    defaultsSettings.title = 'Confirmar essa ação?'
                    break;
                case 'prompt':
                    defaultsSettings.title = 'Preencha os dados'
                    break;
            }
        }

        var init = function (self) {

            defineModalType();

            $instance.appendTo('body');

            $instance.css({zIndex: statics.priority++});

            $instance.find(elements.box).css({
                minHeight: settings.height, 
                width: settings.width
            });
                    
            self.setTitle(settings.title);
            self.setContent(settings.content);

            $btnCancel.add($linkClose).click(function(e){
                e.preventDefault();
                settings.onCancel.call(this);
                self.close();
            });
            
            $btnConfirm.click(function(e){
                e.preventDefault();

                if (settings.type == 'prompt') {
                    var value = $instance.find(elements.inputPrompt).val();

                    if (!settings.onConfirm.call(self, value)) {
                        self.close();
                    }

                } else {
                    settings.onConfirm.call(this)
                    self.close();
                }
            });
        }

        /**
            * Modifica o título do modal.
            * Esse método é chamado automaticamente na inicialização
        */

        this.setTitle = function (title) {
            $instance.find(elements.title).html(title);
            return this;
        }

        /**
            * Modifica o conteúdo do modal
        */

        this.setContent = function (content) {
            $body.html(content);

            if (settings.type == 'prompt') {
                $body.append($('<input />', {
                    "type": "text", 
                    "class": elements.inputPrompt.replace('.', '')
                }));
            }
            return this;
        }

        /**
            * Modifica o conteúdo do modal, utilizando template do undescore.js
            * O argumento a ser passado é o seletor utilizado no jquery
            * Exemplo 
                object = new WmModal($('.wm-modal'), {data: 'myData'})
                object.open().setContentFromTemplate('#template', {data: 'myData'})
        */

        this.setContentFromTemplate = function (templateSelector, data) {
            var template = $(templateSelector).html();
            return this.setContent(_.template(template).call(null, data || {}));
        }


        /**
            * Abre o modal
            * O parametro passado em settings.onOpen é o seletor jQuery referente ao modal
            * É possível utilizar os efeitos para definidos em "static.effectsShow" para modificar a transição de visualização
        **/

        this.open = function (effect) {
            effect = effect || 'fadeIn';

            settings.onOpen.call($instance);

            if ($.inArray(effect, statics.effectsShow) !== -1) {
                $instance[effect].apply($instance, [].slice.call(arguments, 1));
            }

            return this;
        }

        /**
            * Fecha o modal
            * Esse método já é utilizado automaticamente
              nos eventos de click de $btnConfirm e $btnCancel
        */

        this.close = function (callback){
            $instance.fadeOut();
            return this;
        }

        this.destroy = function(){
            $instance.remove()
        }

        init(this);
        
    }

})();
