$(document).ready(function() {

    $('#navbarDropdownProfile').trigger("click");

    $('[data-toggle="tooltip"]').tooltip();
    $('.tooltip').tooltip();
    
    $('[data-toggle="tooltip"]').on('click', function () {
        $(this).tooltip('hide')
    });
    
    $(window).scroll(function() {
        if ($('.navbar').offset().top > 50 ){
            $('.navbar').removeClass("navbar-transparent");
            $('.navbar').addClass("bg-primary");
        }else{
            $('.navbar').removeClass("bg-primary");
            $('.navbar').addClass("navbar-transparent");
        }
    });
     
});