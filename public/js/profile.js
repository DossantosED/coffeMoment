const Toast = Swal.mixin({
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 2000,
    timerProgressBar: true,
    didOpen: (toast) => {
      toast.addEventListener('mouseenter', Swal.stopTimer)
      toast.addEventListener('mouseleave', Swal.resumeTimer)
    },
    willClose: () => {
        location.reload();
    }
})

const Toast2 = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 2000,
})


$(document).on("click",".btn-delete", function(){
    $(this).blur()
    let id = $(this).data("id");
    let div = $(this).data("target");
    Swal.fire({
        title: 'Desea eliminar esta publicación?',
        showDenyButton: true,
        showCancelButton: false,
        confirmButtonText: `Eliminar`,
        denyButtonText: `Cancelar`,
    }).then((result) => {
        /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
            $.ajax({
                type: 'POST',
                url: '/postDelete',
                data: {
                    id: id
                },
                headers: {
                    'X-CSRF-TOKEN': $('input[name=_token]').val()
                },
                success: function (data) {
                    Toast2.fire({
                        icon: 'success',
                        title: data
                    })
                    setTimeout(function(){$('#idPub-'+div).hide('slow', function(){ $('#idPub-'+div).remove(); })},400)
                    if($('.col-lg-6').length == 2){
                        $('#title').text("No hay Publicaciones para mostrar")
                    }
                },
                error: function (data) {
                    Toast2.fire({
                        icon: 'error',
                        title: 'error'
                    })
                }
            });
        }
    })
})

$(".avatar").on("mouseover", function () {
    if($('#editAvatar').css("opacity") == 0){
        $('#editAvatar').css("opacity",1);
    }
})

$(".container").on("mouseover", function () {
    if($('#editAvatar').css("opacity") == 1){
        $('#editAvatar').css("opacity",0);
    }
})

$(".banner-img").on("mouseover", function () {
    if($('#editAvatar').css("opacity") == 1){
        $('#editAvatar').css("opacity",0);
    }
})

var evt;
document.onmousemove = function (e) {
    e = e || window.event;
    evt = e;
}

$(document).on("click",".btn-edit", function(){
    let id = $(this).data("id");
    $('#original_content'+id).css("display","none");
    $('#content'+id).css("display","block");
    $('#btn-save'+id).css("display","block");
    $('#content'+id).focus();
    $('#content'+id).focusout( function(e){
        if (evt.target.id != "btn-save"+id) {
            $('#original_content'+id).css("display","block");
            $('#content'+id).css("display","none");
            $('#btn-save'+id).css("display","none");
        }
    });
})

$('#enviarPost').on("click", function(){

    $.ajax({
        type: 'POST',
        url: '/postCreate',
        data: {
            content: $('#content').val()
        },
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        },
        beforeSend: function(){
            $('#enviarPost').attr("disabled",true);
            $('#enviarPost').html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Enviando...')
        },
        success: function (data) {
            Toast.fire({
                icon: 'success',
                title: data
            })
        },
        error: function (data) {
            Toast2.fire({
                icon: 'error',
                title: data.responseJSON.msg
            })
            $('#enviarPost').attr("disabled",false);
            $('#enviarPost').html('<i class="material-icons">send</i> Guardar')
        }
    });

});

$(document).on("click",".btn-save", function(){
    let idEncrypt = $(this).data("idcifrado");
    let id = $(this).data("id")
    editarPost(id, idEncrypt);
})

function editarPost(id, idEncrypt){
    $.ajax({
        type: 'POST',
        url: '/postEdit',
        data: {
            content: $('#content'+id).val(),
            id: idEncrypt
        },
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        },
        beforeSend: function(){
            $('#btn-save'+id).attr("disabled",true);
            $('#btn-save'+id).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...')
        },
        success: function (data) {
            Toast2.fire({
                icon: 'success',
                title: data
            })
            $('#original_content'+id).text($('#content'+id).val());
            setTimeout(function(){$('#content'+id).focusout(),1000})
            $('#btn-save'+id).attr("disabled",false);
            $('#btn-save'+id).html('<i class="material-icons">send</i> Guardar')
        },
        error: function (data) {
            Toast2.fire({
                icon: 'error',
                title: data.responseJSON.msg
            })
            $('#btn-save'+id).attr("disabled",false);
            $('#btn-save'+id).html('<i class="material-icons">send</i> Guardar')
        }
    });
}
