$(document).ready(function() {

    $('#navbarDropdownProfile').trigger("click");

    $('[data-toggle="tooltip"]').tooltip();
    $('.tooltip').tooltip();
    
    $(window).scroll(function() {
        if ($('.navbar').offset().top > 50 ){
            $('.navbar').removeClass("navbar-transparent");
            $('.navbar').addClass("bg-primary");
        }else{
            $('.navbar').removeClass("bg-primary");
            $('.navbar').addClass("navbar-transparent");
        }
    });

    $(document).on("click",".btn-delete", function(e){
        e.preventDefault();
        let id = $(this).data("target");
        Swal.fire({
            title: 'Desea eliminar esta publicación?',
            showDenyButton: true,
            showCancelButton: false,
            confirmButtonText: `Eliminar`,
            denyButtonText: `Cancelar`,
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'center',
                    showConfirmButton: false,
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                      toast.addEventListener('mouseenter', Swal.stopTimer)
                      toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                  })
                  $("#formDelete"+id).submit();
                  Toast.fire({
                    icon: 'success',
                    title: 'Publicación eliminada!'
                  })
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
    $(document).on("click",".btn-edit", function(e){
        e.preventDefault();
        let id = $(this).data("target");
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
        $('#btn-save'+id).on("click", function(){
            $('#contentEdit'+id).val($('#content'+id).val());
            $("#formEdit"+id).submit();
        })
    })
     
});