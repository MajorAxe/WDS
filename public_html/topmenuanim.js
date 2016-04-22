$(document).ready(function(){

    $(".mymagicoverbox").click(function()
    {
        $('#myfond_gris').fadeIn(300);
        var iddiv = $(this).attr("iddiv");
        $('#'+iddiv).fadeIn(300);
        $('#myfond_gris').attr('opendiv',iddiv);
        return false;
    });

    $('#myfond_gris, .mymagicoverbox_fermer').click(function()
    {
        var iddiv = $("#myfond_gris").attr('opendiv');
        $('#myfond_gris').fadeOut(300);
        $('#'+iddiv).fadeOut(300);
    });

    $('.icon-menu').click(function() {
        $('.menu').animate({
            left: "0px"
        }, 200);

        $('body').animate({
            left: "285px"
        }, 200);
    });

    /* Then push them back */
    $('.icon-close').click(function() {
        $('.menu').animate({
            left: "-285px"
        }, 200);

        $('body').animate({
            left: "0px"
        }, 200);
    });
});
