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
        padding     : [20, 20, 20, 20],
        helpers : {
            title   : {
                type: 'inside',
                position: 'bottom'
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
levinfo.fotorama = function() {
    var $fotoramaDiv = $('.js-fotorama').fotorama({
        height: $('.js-slider').height(),
        width: '100%',
        fit: 'cover',
        arrows: false,
        nav: false,
        loop: true
    });
    var fotorama = $fotoramaDiv.data('fotorama');
    $('.js-slider .js-prev').on('click', function(){
        fotorama.show('<');
        return false;
    });
    $('.js-slider .js-next').on('click', function(){
        fotorama.show('>');
        return false;
    });
}
levinfo.audio = function() {
    $('.js-audio-open').on('click', function(){
        $(this).parents('.js-audio-cont').find('.js-audio').slideToggle();
    });
    $('.js-audio-opened').find('.js-audio').show();
}
levinfo.main = function() {
    levinfo.fancybox();
    levinfo.selects();
    if($('.js-tabs-parent').length)
        levinfo.stabs();
    if($('.js-slider').length)
        levinfo.fotorama();
    if($('.js-audio-cont').length)
        levinfo.audio();
    $('.js-autosize').autosize();
}
$(function(){
    levinfo.main();
});