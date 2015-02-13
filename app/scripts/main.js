/* jshint devel:true */
var levinfo = {};
levinfo.stabs = function() {
    var tab_link = $('.js-tab-link');
    tab_link.on('click', function(){
        clickit($(this));
    });
    var clickit = function(elem) {
        var parent = elem.parents('.js-tabs-parent');
        var tab = parent.find('.js-tab');
        if(elem.hasClass('active')) {
            elem.removeClass('active');
            tab.slideUp();
        } else {
            elem.addClass('active');
            if(elem.siblings().hasClass('active')) {
                tab.eq(elem.index()).show()
                    .siblings().hide();
            } else {
                tab.eq(elem.index()).slideDown()
                    .siblings().hide();
            }
            
        }
        elem.siblings().removeClass('active');
    }
}
levinfo.selects = function() {
    $('select').each(function(){
        var width = $(this).width() + 20;
        $(this).selectmenu({
            'width': width
        });
    });
}
levinfo.fancybox = function() {
    $(".js-fancybox").fancybox({
        prevEffect  : 'none',
        nextEffect  : 'none',
        margin      : [20, 150, 20, 150],
        padding     : [20, 20, 30, 20],
        helpers : {
            title   : {
                type: 'inside',
            },
            thumbs  : {
                width   : 80,
                height  : 60
            }
        },
        beforeLoad: function() {
        },
        afterShow: function() {
        }
    });
}
levinfo.main = function() {
    levinfo.fancybox();
    levinfo.selects();
    if($('.js-tabs-parent').length)
        levinfo.stabs();
    $('.js-autosize').autosize();
}
$(function(){
    levinfo.main();
});