$(function(){

    var $radioLocal = $('[name=local_jogo]');

    var $selectLigaId = $("#liga_id");



    $radioLocal.change(function(){

        var value = $(this).val()

    })

    $('#selecionar-adversario').autocomplete({

        source: function (request, response) {

            var id = $selectLigaId.val();

            if (!id) return;

            $.ajax({

                url: '/user/ajax-usuario-jogadores-liga/' + id,
                data: {nome: request.term},
                success: function(data) {


                    $.each(data, function(a, object){

                        object.value = object.clube.nome + ' - ' + object.usuario.nome
                    })

                    response(data)
                },

            })
        },

        select: function (e, ui){
            
            console.log(ui.item)

            $(":hidden#adversario-id").val(ui.item.usuario_id)
        }
    })

})