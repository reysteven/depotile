$(document).ready(function () {
    // toggle search mobile
    $('.triggerSearch').click(function(){
        if($(this).hasClass('active')) {
            $(this).removeClass('active');
            $('.searchMobile').slideUp(150);
        }else {
            $(this).addClass('active');
            $('.searchMobile').slideDown(150);
        }
    })

    // toggle menu
    function toggleNavbarMethod() {
        if ($(window).width() > 768) {
            $('.dropdown').hover(function(){
                $(this).find('.dropdown-menu').stop().fadeIn(150);
            },function(){
                $(this).find('.dropdown-menu').stop().fadeOut(150);
            });
        }
        else {
            $('.navbar .dropdown').off('mouseover').off('mouseout');
        }
    }
    toggleNavbarMethod();
    $(window).resize(toggleNavbarMethod);

    //for scroll header
    setTimeout(function () {
        var scrolls = $(window).scrollTop()
        if(scrolls > 55)
        {
            $('.headerWrap').addClass('headerActive');;
        }
        else{
            $('.headerWrap').removeClass('headerActive');
        }
    },100)

    $(window).scroll(function() {
        if($(window).width() > 768)
        {
            var st = $(window).scrollTop();
            func_dynamic(scroll,st);
            scroll = st
        }
    });
    function func_dynamic(scroll,st)
    {
        if(scroll > 55)
        {
            $('.headerWrap').addClass('headerActive');;
        }
        else{
            $('.headerWrap').removeClass('headerActive');
        }
    }

    // MMENU
    $(function() {
        $("#menu").mmenu({
            "extensions": [
                "theme-dark"
            ],
            "navbars": [
                {
                    "position": "top"
                }
            ],
            classNames: {
            fixedElements: {
                fixed: "headerWrap"
            }
        }
        });
    });
})