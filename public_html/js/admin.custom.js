site.initAll = function () {
    $("#galaccord").accordion();
    $(".cropbutton").button({
            icons: {
                primary: "ui-icon-scissors"
            },
            text: false
    });
    $(".editbutton").button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: false
    });
    $(".deletebutton").button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: false
    });
}
$(function() {
    $(".toggleNext").live('click', function() {
        $(this).find(".toggled").toggle();
        $(this).nextAll(".toggled").slideToggle(300);
    });

    /*$('.button').button({
        icons:{ primary:'ui-icon-home'},
        text:false
        
    
    })*/
});