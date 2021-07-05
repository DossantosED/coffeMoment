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

$('#addImage').on("click", function(){
    $('#divImage').toggle("slow");
})


$(document).on("click",".btn-delete", function(){
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

$("#editAvatar").on({
    mouseenter: function(){
        $('#editAvatar').css("opacity",1);
    },
    mouseleave: function(){
        $('#editAvatar').css("opacity",0);
    }
});

$(".avatar").on({
    mouseenter: function(){
        $('#editAvatar').css("opacity",1);
    },
    mouseleave: function(){
        $('#editAvatar').css("opacity",0);
    }
});


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

    var paqueteDeDatos = new FormData();
    paqueteDeDatos.append('file', $('#imagenUpload')[0].files[0]);
    paqueteDeDatos.append('content',$('#content').val());
    $.ajax({
        type: 'POST',
        url: '/postCreate',
        processData: false,
        cache: false,
        contentType: false,
        data: paqueteDeDatos,
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

$('#editAvatar').on("click", function(){
    $('#avatarUpload').trigger("click");
})

$('#editBanner').on("click", function(){
    $('#bannerUpload').trigger("click");
})

$('#avatarUpload').on("change", function(){
    uploadImage('#avatarUpload', '.avatar', false);
})

$('#bannerUpload').on("change", function(){
    uploadImage('#bannerUpload', '.banner-img', true);
})

function uploadImage(input, classNanme, isBanner){
    if($(input).val() != ""){
        var imagen = new FormData();
        imagen.append('file', $(input)[0].files[0]);
        imagen.append('banner', isBanner);
        $.ajax({
            type: 'POST',
            url: '/upload',
            processData: false,
            cache: false,
            contentType: false,
            dataType: 'json',
            data: imagen,
            headers: {
                'X-CSRF-TOKEN': $('input[name=_token]').val()
            },
            success: function (data) {
                Toast2.fire({
                    icon: 'success',
                    title: data.msg
                })
                $(classNanme).attr("src", "/img/faces/"+data.img)
            },
            error: function (data) {
                Toast2.fire({
                    icon: 'error',
                    title: data.msg
                })
            }
        });
        $(input).val("");
    }
}

$(document).on("click",".btn-like", function(){
    let idPost = $(this).data('id');
    likePost(idPost);
})

function likePost(idPost){
    $.ajax({
        type: 'POST',
        url: '/likePost',
        data: {
            id: idPost
        },
        headers: {
            'X-CSRF-TOKEN': $('input[name=_token]').val()
        },
        success: function (data) {
            $("#idPub-"+idPost+ " > div > div.card-footer.justify-content-center > button.btn.btn-primary.btn-lg.btn-like > i:nth-child(2)")[0].innerText = data+" ME GUSTA";
            if(data != '0'){
                $("#idPub-"+idPost+ " > div > div.card-footer.justify-content-center > button.btn.btn-primary.btn-link.btn-lg.btn-like > i.material-icons")[0].style.color = "#9c27b0";
            }else{
                $("#idPub-"+idPost+ " > div > div.card-footer.justify-content-center > button.btn.btn-primary.btn-link.btn-lg.btn-like > i.material-icons")[0].style.color = "grey";
            }
        },
        error: function () {
            Toast2.fire({
                icon: 'error',
                title: 'error desconocido'
            })
        }
    });
}

