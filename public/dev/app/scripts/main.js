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
        //openEffect  : 'elastic',
        //closeEffect : 'elastic',
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
        fit: 'contain',
        arrows: false,
        nav: false,
        loop: true,
        click: false
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
    $('.js-fororama').on('click', function(){
        alert(1);
    });
}
levinfo.audio = function() {
    $('.js-audio-open').on('click', function(){
        var parent = $(this).parents('.js-audio-cont');
        if(parent.hasClass('js-audio-opened')) return false;
        parent.find('.js-audio').slideToggle();
        return false;
    });
    $('.js-audio-opened').find('.js-audio').show();
}
levinfo.simpletabs = function() {
    var stab = $('.js-stab');
    var slink = $('.js-slink');
    var show = function(name) {
        slink.filter('[data-name="' + name + '"]').addClass('active')
            .siblings().removeClass('active');
        stab.filter('[data-tab="' + name + '"]').show()
            .siblings().hide();
    }
    var init = function() {
        var first_name = slink.first().attr('data-name');
        show(first_name);
        slink.on('click', function(){
            show($(this).attr('data-name'));
        });
    }
    init();
}
levinfo.lawPopup = function() {
    var open_link = $('.js-open-law');
    var law_popup = $('.js-law-popup');
    var law_overlay = $('.js-law-overlay');
    var law_item = $('.js-law-item');
    var close_link = $('.js-law-close');
    var prev_arrow = $('.js-law-prev');
    var next_arrow = $('.js-law-next');
    var active_item = false;
    var active_popup = false;
    var change_allow = true;
    var opened = false;
    var open = function(id, animate) {
        if(change_allow) {
            var filter_str = '[data-law-id="' + id + '"]';
            var this_popup = law_popup.filter(filter_str);
            var this_item = law_item.filter(filter_str);
            $('html').css('overflow', 'hidden');
            if(animate) {
                change_allow = false;
                var close_popup = active_popup;
                var show_popup = this_popup;
                if(animate == 'next') {
                    close_popup.addClass('faded');
                }
                if(animate == 'prev') {
                    close_popup.addClass('faded-right');
                }
                show_popup.addClass('from-fade').show();
                setTimeout(function(){
                    show_popup.removeClass('from-fade');
                }, 10);
                setTimeout(function(){
                    close_popup.removeClass('faded faded-right').hide();
                    change_allow = true;
                }, 250);
            } else {
                this_popup.siblings('.js-law-popup').hide();
                this_popup.show();
            }
            law_overlay.fadeIn();
            if(this_item.next('[data-law-id]').length) {
                next_arrow.show();
            } else {
                next_arrow.hide();
            }
            if(this_item.prev('[data-law-id]').length) {
                prev_arrow.show();
            } else {
                prev_arrow.hide();
            }
            active_item = this_item;
            active_popup = this_popup;
            law_overlay.scrollTop(0);
            opened = true;
        }
    }
    var close = function() {
        law_overlay.fadeOut(function(){
            $('html').removeAttr('style');
            law_popup.hide();
            opened = false;
        });
    }
    var init = function() {
        open_link.on('click', function(){
            var id = $(this).parents('.js-law-item').attr('data-law-id');
            open(id, false);
            return false;
        });
        prev_arrow.on('click', function(e){
            var this_id = active_item.prev().attr('data-law-id');
            open(this_id, 'prev');
            e.stopPropagation();
            return false;
        });
        next_arrow.on('click', function(e){
            var this_id = active_item.next().attr('data-law-id');
            open(this_id, 'next');
            e.stopPropagation();
            return false;
        });
        law_overlay.on('click', function(e){
            close();
        });
        law_popup.on('click', function(e){
            e.stopPropagation();
        });
        $(document).on('keydown', function (e) {
            if(opened) {
                if(e.keyCode == 39) {
                    if(next_arrow.is(":visible"))
                        next_arrow.trigger('click');
                }
                if(e.keyCode == 37) {
                    if(prev_arrow.is(":visible"))
                        prev_arrow.trigger('click');
                }
            }
        });
        close_link.on('click', function(){
            close();
            return false;
        });
    }
    init();
}
levinfo.newsText = function() {
    var parent = $('.js-news-text');
    var news_img = parent.find('img');
    news_img.each(function(){
        $(this).hide();
        var this_src = $(this).attr('src');
        var this_alt = $(this).attr('alt');
        var alt_str = '';
        if(this_alt) {
            var alt_str = '<div class="img-desc">' + this_alt + '</div>';
        }
        var parent_p = $(this).parent();
        var toP;
        if(parent_p.prev().length) {
            toP = parent_p.prev();
        } else if(parent_p.next().length) {
            toP = parent_p.next();
        }
        var html = '<div class="news-img js-fancybox" rel="gallery" href="' + this_src + '" title="' + this_alt + '">\
                        <img class="img-photo" src="' + this_src + '" alt="' + this_alt + '">\
                        ' + alt_str + '\
                    </div>';
        console.log(toP);
        if(toP) {
            toP.prepend(html);
            toP.append('<div class="clearfix"></div>');
            var new_html = toP.html();
            toP.after('<div>' + new_html + '</div>');
            toP.remove();
            parent_p.remove();
        }
    });
    //levinfo.fancybox();
}
levinfo.contactForm = function() {
    jQuery.extend(jQuery.validator.messages, {
            required: "Это поле необходимо заполнить.",
            remote: "Пожалуйста, введите правильное значение.",
            email: "Пожалуйста, введите корретный адрес электронной почты.",
            url: "Пожалуйста, введите корректный URL.",
            date: "Пожалуйста, введите корректную дату.",
            dateISO: "Пожалуйста, введите корректную дату в формате ISO.",
            number: "Пожалуйста, введите число.",
            digits: "Пожалуйста, вводите только цифры.",
            creditcard: "Пожалуйста, введите правильный номер кредитной карты.",
            equalTo: "Пожалуйста, введите такое же значение ещё раз.",
            accept: "Пожалуйста, выберите файл с правильным расширением.",
            maxlength: jQuery.validator.format("Пожалуйста, введите не больше {0} символов."),
            minlength: jQuery.validator.format("Пожалуйста, введите не меньше {0} символов."),
            rangelength: jQuery.validator.format("Пожалуйста, введите значение длиной от {0} до {1} символов."),
            range: jQuery.validator.format("Пожалуйста, введите число от {0} до {1}."),
            max: jQuery.validator.format("Пожалуйста, введите число, меньшее или равное {0}."),
            min: jQuery.validator.format("Пожалуйста, введите число, большее или равное {0}.")
    });

    $(".js-contact-form").validate({
        rules: {
            name: "required",
            message: "required",
            email: {
                required: function(element) {
                    return $('[name="phone"]').val().length == 0;
                },
                email: true
            },
            phone: {
                required: function(element) {
                    return $('[name="email"]').val().length == 0;
                }
            }
        },
        submitHandler: function(form) {
            var options = { 
                beforeSubmit: function(){
                    $('.js-form-error').hide();
                    $(form).find('[type="submit"]').addClass('loading')
                        .attr('disabled', 'disabled');
                }, 
                success: function(data){
                    if(data.status) {
                        $('.js-form-success').fadeIn();
                        setTimeout(function(){
                            $('.js-form-cont').slideUp();
                        }, 3000);
                    } else {
                        $('.js-form-error').show();
                    }
                    $(form).find('[type="submit"]').removeClass('loading')
                        .removeAttr('disabled');
                },
                error: function() {
                    $('.js-form-error').show();
                    $(form).find('[type="submit"]').removeClass('loading')
                        .removeAttr('disabled');
                }
            };
            $(form).ajaxSubmit(options);
        }
    });
    $('[name="phone"], [name="email"]').on('input', function(){
        if($('#phone-error').is(':visible') && $('#email-error').is(':visible'))
            $(".js-contact-form").valid();
    });
}
levinfo.sharing = function() {
    $('.js-share').on('click', function(){
        var newWin = window.open($(this).attr('href'),
           "Поделиться",
           "width=420,height=230,resizable=yes,scrollbars=yes,status=yes"
        );
        return false;
    });
}
levinfo.main = function() {
    levinfo.selects();
    if($('.js-fancybox').length)
        levinfo.fancybox();
    if($('.js-tabs-parent').length)
        levinfo.stabs();
    if($('.js-slider').length)
        levinfo.fotorama();
    if($('.js-audio-cont').length)
        levinfo.audio();
    if($('.js-slink').length && $('.js-stab').length)
        levinfo.simpletabs();
    if($('.js-open-law').length)
        levinfo.lawPopup();
    if($('.js-news-text').length)
        levinfo.newsText();
    if($('.js-contact-form').length)
        levinfo.contactForm();
    if($('.js-share').length)
        levinfo.sharing();
    $('.js-autosize').autosize();
}
$(function(){
    levinfo.main();
});