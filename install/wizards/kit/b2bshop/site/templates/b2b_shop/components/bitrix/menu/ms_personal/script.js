$(document).ready(function () {
    location.href = "#form-successful";

    $('form[name="SIMPLE_FORM_CALLBACK_MANAGER"] [type="Телефон"] input').each(function (index, element) {
        $(element).attr('id', 'phone')
    })

    $('.order-phone').click(function () {
        $('[valid="true"] input').each(function (index, element) {
            $(element).attr('required', 'true')
        })


        var width = $('body').innerWidth()
        if (width < 760) {
            // $('form[name="SIMPLE_FORM_CALLBACK_MANAGER"]').css({'position':'',
            //     'width':'',
            //     'z-index':'25',
            // })


        } else {

            $('.overlay').fadeIn();
        }
        $('form[name="SIMPLE_FORM_CALLBACK_MANAGER"]').fadeIn();

    })
    $('.button-close').on("click", function () {
        $('.overlay').fadeOut();
        $('form[name="SIMPLE_FORM_CALLBACK_MANAGER"]').fadeOut();
    })
    $('.successful-close').click(function () {
        location.assign("/personal/")
        $('.overlaySuccessful').fadeOut();
    })
    $('.overlay').click(function () {
        $(this).fadeOut()
        $('.form-successful, form[name="SIMPLE_FORM_CALLBACK_MANAGER"]').fadeOut();

    })
    $(window).resize(function () {
        var width = $('body').innerWidth()
        if (width < 760) {
            $('.overlay, .overlaySuccessful').fadeOut();
        }
    })



    $('[valid="true"] input').blur(function () {
        if ($(this).val() == '') {
            $(this).css({"outline": "1px solid red"})
        } else {
            $(this).css({"outline": "none"})
        }
    })


    $('.form-button').click(function () {
        $('[valid="true"] input').each(function (index, element) {
            if ($(element).val() == '') {
                $(element).css({"outline": "1px solid red"})
            } else {
                $(element).css({"outline": "none"})
            }

        })

    })

});


$(document).on('focus', '#phone', function () {
    maska = $(".fild input[name='TEL_MASKS1']").eq(0).val();
    jQuery.mask.definitions['~'] = '[+-9() ]';
    maska = $.trim(maska);
    $(this).mask(maska, {placeholder: "_"});
});