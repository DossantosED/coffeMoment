$(function () {

    $(".imageUpload").fileinput({
        showPreview: true,
        showUpload: false,
        language: "es",
        theme: "",
        autoOrientImage: false,
        required: true,
        maxFileSize: 2000,
        showRemove: false,
        allowedFileExtensions: ["jpg", "png", "jpeg"],
        browseClass: "btn btn-success",
        browseLabel: "Subir imagen",
        browseIcon: "<i class=\"material-icons\">image</i>",
        initialPreviewAsData: false,
        initialPreviewFileType: 'image'
    });

    paintBar();

    $('#navbarDropdownProfile').trigger("click");

    $(window).scroll(function() {
        paintBar();
    });

    function paintBar(){
        if ($('.navbar').offset().top > 1 ){
            $('.navbar').removeClass("navbar-transparent");
            $('.navbar').addClass("bg-primary");
        }else{
            $('.navbar').removeClass("bg-primary");
            $('.navbar').addClass("navbar-transparent");
        }
    }
     
});