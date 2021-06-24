$(document).ready(function() {
    
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