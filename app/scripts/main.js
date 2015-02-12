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
levinfo.main = function() {
    if($('.js-tabs-parent').length)
        levinfo.stabs();
}
$(function(){
    levinfo.main();
});