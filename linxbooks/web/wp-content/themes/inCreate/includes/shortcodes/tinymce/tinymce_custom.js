jQuery(document).ready(function ($) {

    $(".panel-icon i").toggle(
        function(){
            $(".panel-icon i").removeClass('selected');
            var icon = $(this).attr('class');
            $(this).closest('.panel-icon').find('input.icon_class').val(icon);
            $("#icon_class").val(icon);
            $(this).addClass('selected');           
        },
        function(){
            $(".panel-icon i").removeClass('selected');
            var icon = $(this).attr('class');
            $(this).closest('.panel-icon').find('input.icon_class').val('');
        }

    );


    //stop the flash from happening
    
    function calcTB_Pos() {
        $('#TB_ajaxContent').css({
           'height': ($('#TB_window').outerHeight() - 60) + 'px',
           'opacity' : 1
        });
    }
    
    setTimeout(calcTB_Pos,10);
    
    //just incase..
    setTimeout(calcTB_Pos,100);
    
    $(window).resize(calcTB_Pos);


    $("ul.tab-titles").jttabs("> .tab-content");
    $('.toggle-content').each(function () {
        if (!$(this).hasClass('default-open')) {
            $(this).hide();
        } else if ($(this).hasClass('default-open')) {
            $(this).parents('.toggle-item').find('.arrow').removeClass('fa-plus').addClass('fa-minus');
        }
    });





    var repeated_item = $('.repeated-item');
    var repeatable = repeated_item.find(".repeat").clone(true);


    var add = repeated_item.find(".add");
    add.live('click', function(){
        r = $(this).siblings('.repeat:first').clone(true);
        r.find("input[type='text']").attr("value","");
        $(this).parent('.repeated-item').append(r);
        new jscolor.color(r.find('.color')[0], {});
    });


    repeated_item.find(".repeat").on("click", ".remove", function(e) {
        if( $(".current .repeat").length > 1 ) {
                $(this).parents('.repeat').remove();

        } 
    });


});