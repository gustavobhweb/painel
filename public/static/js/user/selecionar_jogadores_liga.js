var delay = (function(){
    var timeout = 0;
    return function (ms, callback) {
        clearTimeout(timeout);
        timeout = setTimeout(callback, ms);
    }
})();

$(function(){

    var tplJogadores = $("#tpl-jogadores").html(),
        $boxJogadores = $('#container-jogadores');

    $('#pesquisar-jogadores').keyup(function(){

        var $self = $(this),
            value = $self.val(),
            liga_id = $("#liga-id").val();

        delay(500, function () {
            $.ajax({
                url: '/user/ajax-listar-jogadores',
                data: {nome: value, liga_id: liga_id},
                success: function (response) {
                    var html = _.template(tplJogadores)({jogadores: response});

                    $boxJogadores.html(html).fadeIn();

                }
            });
        }); 
    });


    var modalError = new WmModal(null, {title: 'Mensagem de Erro'});


    $(document).on('click', '#ajax-jogadores .player', function(e) {
        e.preventDefault();
        e.stopPropagation();

        var $self   = $(this),
            imgSrc  = $self.find('.jogador-img-ajax').data('src');


        var formData = {
            jogador_id : $self.data('id'),
            liga_id    : $("#liga-id").val()
        };

        $.post('/user/ajax-cadastrar-jogador-liga', formData, function (response)
        {
            if (response.error !== false) {                
                return modalError.setContent(response.error).open();
            }

            $self.appendTo("#jogadores-listagem");

        }).fail(function(error){
             return modalError.setContent(error.responseJSON.error.message).open();
        });

    });

    $(document).click(function(){
        $boxJogadores.fadeOut();
    });

    $(document).on('click', '.remove-player', function (e) {
        e.preventDefault();

        var $parent = $(this).closest('.player');

        var formData = {
            liga_id     : $('#liga-id').val(),
            jogador_id  : $parent.data('id'),
            _token      : $('[name=_token]').val()
        };

        $.post('/user/ajax-deletar-jogador-liga', formData, function (response) {

            if (!response.error) {

                return $parent.remove();

            }
        })
    });
})