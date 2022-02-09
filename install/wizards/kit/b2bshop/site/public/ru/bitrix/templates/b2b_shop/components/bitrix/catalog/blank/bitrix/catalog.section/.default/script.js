$(document).ready(function ()
{
    if ($('.blank_list_in_menu').length)
    {
        $('.blank_list_in_menu').niceScroll(".blank_list_in_in_menu", {
            cursoropacitymin: 1,
            enabletranslate3d: false,
            cursorfixedheight: '16',
            scrollspeed: 5,
            mousescrollstep: 5,
            cursorwidth: '5px',
            horizrailenabled: false,
            cursordragontouch: true
        });
    }
    var w = $(window).width();

    $(document).on("change", ".block-pagination select", function ()
    {
        form = $(this).parents(".block-pagination").eq(0).parents("form").eq(0);
        ajaxID = form.find("[name=bxajaxid]").attr("id");
        ajaxValue = form.find("[name=bxajaxid]").attr("value");
        var obForm = top.BX(ajaxID).form;
        BX.ajax.submitComponentForm(obForm, 'comp_' + ajaxValue, false);
        BX.submit(obForm, "save", "Y", function ()
        {

        });
    });

    $(document).on("click", "#blank_kategorii_button", function ()
    {
        form = $(this).closest("form").eq(0);
        ajaxID = form.find("[name=bxajaxid]").attr("id");
        ajaxValue = form.find("[name=bxajaxid]").attr("value");
        var obForm = top.BX(ajaxID).form;
        BX.ajax.submitComponentForm(obForm, 'comp_' + ajaxValue, false);
        BX.submit(obForm, "save_kategorii", "Y", function ()
        {

        });
    });


    $(document).on("click", "#hide_blank_filter", function ()
    {
        $('#filter-form-wrapper').slideToggle('normal', function ()
        {
            if ($("#hide_blank_filter").hasClass('blank_filter_open'))
            {
                $("#hide_blank_filter").find('.hide_blank_filter_text').html(BX.message("MS_JS_CATALOG_FILTER_HIDE"));
                $("#hide_blank_filter").removeClass('blank_filter_open');
                $.ajax({
                    type: 'POST',
                    url: SITE_DIR + 'include/ajax/blank_filter_hide.php',
                    data: {
                        'hide': 'N'
                    },
                    success: function (data)
                    {
                    },
                });
            }
            else
            {
                $("#hide_blank_filter").find('.hide_blank_filter_text').html(BX.message("MS_JS_CATALOG_FILTER_SHOW"));

                $("#hide_blank_filter").addClass('blank_filter_open');
                $.ajax({
                    type: 'POST',
                    url: SITE_DIR + 'include/ajax/blank_filter_hide.php',
                    data: {
                        'hide': 'Y'
                    },
                    success: function (data)
                    {
                    },
                });
            }
        });
    });
    $(document).on("click", "#blank_excel_out", function ()
    {
        excelOut();

    });

    $(document).on("click", "#blank_categorii", function ()
    {
        $('#blank_list').fadeToggle();
    });

    $(document).on("click", "#blank_excel_in", function ()
    {
        $('#excel_in_form').fadeToggle();
    });
    /*
    $(document).on("click", ".blank_resizer_tool", function()
    {
        if(!$('.blank_resizer_tool').hasClass('blank_resizer_tool_open'))
        {
            $('#blank_left_side').hide();

            var resizedPos = $('#wrapper_blank_resizer').offset();
            $('.blank_resizer_tool').css({'left':resizedPos.left - 15});

            $(this).addClass('blank_resizer_tool_open');

            $('#blank_right_side').addClass('blank_right-side_full');

            $.ajax({
                type: 'POST',
                url:SITE_DIR + 'include/ajax/blank_side.php',
                data: {Open:'N'},
                success: function(data){},
                error:  function (jqXHR, exception) {}
            });


            oneColumnWidth();
            oneRowHeight();
            basketWidth();
            var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
            if(!isMobile)
            {
                if($('.blank-modification-center-side_in').length)
                {
                    $('.blank-modification-center-side_in').getNiceScroll().resize();
                }
            }
        }
    });*/

    $(window).resize(function ()
    {
        if ($(window).width() == w) return;
        w = $(window).width();
        oneColumnWidth();
        oneRowHeight();
        basketWidth();
        var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);

        if (!isMobile)
        {
            if ($('.blank-modification-center-side_in').length)
            {
                $('.blank-modification-center-side_in').getNiceScroll().resize();
            }
        }
    });

    /*
    $(document).on("click", ".blank_resizer_tool_open", function()
    {

        $('#blank_right_side').removeClass('blank_right-side_full');

        $('#blank_left_side').show();

        var resizedPos = $('#wrapper_blank_resizer').offset();
        $('.blank_resizer_tool').css({'left':resizedPos.left - 15});

        $(this).removeClass('blank_resizer_tool_open');

        oneColumnWidth();
        oneRowHeight();
        basketWidth();
        var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
        if(!isMobile)
        {
            if($('.blank-modification-center-side_in').length)
            {
                $('.blank-modification-center-side_in').getNiceScroll().resize();
            }
        }


        $.ajax({
            type: 'POST',
            url:SITE_DIR + 'include/ajax/blank_side.php',
            data: {Open:'Y'},
            success: function(data){},
            error:  function (jqXHR, exception) {}
        });
    });
    */
});

$(function ()
{
    if ($('.row-under-modifications').length > 0)
    {
        var topPos = $('.row-under-modifications').offset().top;
        if (topPos > $(window).height())
        {
            topPos = $(window).height();
        }
    }
    /*
    var resizedPos = $('#wrapper_blank_resizer').offset();
    var resizedHeight = $('#wrapper_blank_resizer').height();


    if(resizedToolPos.top < resizedPos.top)
    {
        resizedToolPos.top = resizedPos.top + 100;
        $('.blank_resizer_tool').css({'top':resizedToolPos.top});
    }*/

    $(window).scroll(function ()
    {
        var top = $(document).scrollTop(),
            pip = $('.jacor').offset().top,
            height = $('.row-under-modifications').outerHeight();
        if (pip < top + height + topPos)
        {
            $('.row-under-modifications').addClass('row-under-modifications-fixed');
        }
        else
        {
            if (top > pip - height)
            {
                $('.row-under-modifications').removeClass('row-under-modifications-fixed');
            }
            else
            {
                $('.row-under-modifications').removeClass('row-under-modifications-fixed');
            }
        }

        /*
        var resizedToolPos = $('.blank_resizer_tool').offset();

        if(resizedPos.top + resizedHeight - 100 < resizedToolPos.top)
        {
            $('.blank_resizer_tool').css({'top':resizedPos.top + resizedHeight - 100 - top});
        }
        if(resizedPos.top + 100 > resizedToolPos.top)
        {
            $('.blank_resizer_tool').css({'top':resizedPos.top + 100});
        }*/

    });
});

(function (window, document, $, undefined)
{
    window.msBlankList = function (arParams)
    {
        this.isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
        this.basket_url = "";
        this.btn_class = "";
        this.btn_basket = "";
        this.btn_change_class = "";
        this.basketPath = "";
        this.this_ = this;
        if ('object' === typeof arParams)
        {
            this.basket_url = arParams.basket_url;
            this.btn_class = arParams.btn_class;
            this.btn_change_class = arParams.btn_change_class;
            this.btn_basket = arParams.btn_basket;
            this.basketPath = arParams.basketPath;
            this.ModificationMinus = arParams.ModificationMinus;
            this.ModificationPlus = arParams.ModificationPlus;
            this.ModificationAddBasket = arParams.ModificationAddBasket;

        }
        this.destroy(this);
        this.init(this);
    };
    window.msBlankList.prototype.init = function (_this)
    {

        $(document).on("click", _this.ModificationMinus, _this, _this.clickModificationMinus);
        $(document).on("click", _this.ModificationPlus, _this, _this.clickModificationPlus);
        $(document).on("click", _this.ModificationAddBasket, _this, _this.clickModificationAddBasket);
        $(document).on("change keyup", '.sizes-block-cnt-value', _this, _this.changeInput);
    };
    window.msBlankList.prototype.destroy = function ()
    {
        $(document).off("click", this.ModificationMinus, this.clickModificationMinus);
        $(document).off("click", this.ModificationPlus, this.clickModificationPlus);
        $(document).off("click", this.ModificationAddBasket, this.clickModificationAddBasket);
    };
    window.msBlankList.prototype.changeInput = function (e)
    {
        _this = e.data;
        if ((e.keyCode < 48 || e.keyCode > 57) && e.keyCode != 8 && e.keyCode != 37 && e.keyCode != 39)
            return false;
        changeInput($(this));
    };
    window.msBlankList.prototype.clickModificationMinus = function (e)
    {
        e.preventDefault();
        _this = e.data;
        var OldValue = parseInt($(this).siblings(".sizes-block-cnt-value").val());
        if (OldValue > 0)
        {
            $(this).siblings(".sizes-block-cnt-value").val(OldValue - 1);
            changeInput($(this).siblings('.sizes-block-cnt-value'));
            /*var OfferPrice = Number($(this).closest(".sizes-block-cnt").attr('data-price'));
            var OldPrice = parseFloat($("#modification-basket-price").html());
            var NewPrice = OldPrice - OfferPrice;
            if (NewPrice.toString().indexOf('.') >= 0) NewPrice = NewPrice.toFixed(2);
            $("#modification-basket-price").html(NewPrice);

            var oldCnt = parseInt($("#modification-basket-qnt").html());
            var newCnt = oldCnt-1;
            if(newCnt >= 0)
            {
                $("#modification-basket-qnt").html(newCnt);
            }

            var id = Number($(this).closest(".sizes-block-cnt").attr('data-id'));

            $.ajax({
                type: 'POST',
                url: SITE_DIR + 'include/ajax/blank_ids.php',
                data: {
                    'id': id,
                    'qnt': OldValue-1
                },
                success: function(data) {
                },
            });*/
        }
    };
    window.msBlankList.prototype.clickModificationPlus = function (e)
    {
        e.preventDefault();
        _this = e.data;
        var OldValue = parseInt($(this).siblings(".sizes-block-cnt-value").val());
        $(this).siblings(".sizes-block-cnt-value").val(OldValue + 1);
        changeInput($(this).siblings('.sizes-block-cnt-value'));
        /*var OfferPrice = Number($(this).closest(".sizes-block-cnt").attr('data-price'));
        var OldPrice = Number($("#modification-basket-price").html());
        var NewPrice = OldPrice + OfferPrice;
        if (NewPrice.toString().indexOf('.') >= 0) NewPrice = NewPrice.toFixed(2);
        $("#modification-basket-price").html(NewPrice);

        var oldCnt = parseInt($("#modification-basket-qnt").html());
        var newCnt = oldCnt+1;
        if(newCnt >= 0)
        {
            $("#modification-basket-qnt").html(newCnt);
        }

        var id = Number($(this).closest(".sizes-block-cnt").attr('data-id'));

        $.ajax({
            type: 'POST',
            url: SITE_DIR + 'include/ajax/blank_ids.php',
            data: {
                'id': id,
                'qnt': OldValue+1,
                'price':OfferPrice
            },
            success: function(data) {
            },
        });*/
    };
    window.msBlankList.prototype.clickModificationAddBasket = function (e)
    {
        e.preventDefault();
        _this = e.data;
        cont_modal = $(this);

        $.ajax({
            type: 'POST',
            url: SITE_DIR + 'include/ajax/blank_add_basket.php',
            data: {},
            success: function (data)
            {
                if (data == 'EMPTY')
                {
                    cont_modal.msTooltip({
                        "class": "class_modification_tooltip",
                        "message": BX.message("MS_JS_CATALOG_SELECT_MODIFICATION"),
                        "is_hover": true,
                        "timeOut": true
                    });
                    return false;
                }
                else
                {
                    if (data == 'TRUE')
                    {
                        BX.onCustomEvent('OnBasketChange');
                        changeButton(_this.btn_basket, BX.message("MS_JS_CATALOG_ADDED_BASKET"), _this.basketPath, _this.btn_class, _this.btn_change_class);
                        //$('#modification-basket-qnt').html('0');
                        //$('#modification-basket-price').html('0');
                        //$('.sizes-block-cnt-value').html('0');
                    }
                }
            },
        });

    };
    window.msBlankList.prototype.clickAddBasket = function (e)
    {
        e.preventDefault();
        _this = e.data;

        $.ajax({
            type: 'POST',
            url: SITE_DIR + 'include/ajax/blank_add_basket.php',
            data: {},
            success: function (data)
            {
            },
        });
    };
    window.msBlankList.prototype.afterAddBasket = function ()
    {
        _this = this;
    };
    window.msBlankList.prototype.afterAddBasketMobile = function ()
    {
        _this = this;
        BX.onCustomEvent('OnBasketChange');
    };
})(window, document, jQuery);

function oneColumnWidth()
{

    var colWidth = 100;

    if ($(document).width() < 400)
    {
        colWidth = 75;
    }

    var columnWidth = $('.blank-modification-center-side').width();
    var visCols = Math.floor(columnWidth / colWidth);
    var curCols = $('.blank-modification-center-side .blank-modification-header .blank-modification-header-cell').length;

    if (visCols >= curCols)
    {
        visCols = curCols;
    }
    else
    {
        //$('.blank-modification-center-side').niceScroll({cursoropacitymin: 1, enabletranslate3d: false, cursorfixedheight:'16', scrollspeed: 5, mousescrollstep: 5,  cursorwidth:'5px',horizrailenabled:true,cursordragontouch:true});
    }

    var ceilWidth = columnWidth / visCols;


    $('.blank-modification-column-prop').css({'min-width': ceilWidth + 'px'});
}

function oneRowHeight()
{
    //all rows to one height
    $('.blank-modification-left-side .blank-modification-row').each(function ()
    {
        var c = $(this).attr('class').replace("blank-modification-row", "").trim();
        var max = 0;
        $('.' + c).each(function ()
        {
            var height = $(this).height();
            if (height > max)
            {
                max = height;
            }
        });
        $('.' + c).height(max);
    });
}

function basketWidth()
{
    var blankWidth = $('.blank-modification-in').width();
    $('.row-under-modifications-inner').width(blankWidth);
}

function excelOut()
{
    BX.showWait();
    var params = $('#blank_excel_out').attr('data-params');
    var filter = $('#blank_excel_out').attr('data-filter');
    var ids = $('#blank_excel_out').attr('data-ids');
    var ide = $('#blank_excel_out').attr('data-ide');

    var cnt =500;

    var cntSteps = Math.ceil((ide - ids)/cnt);

    var file = '';

    for(var i = 0;i<cntSteps;++i)
    {
        var idss = parseInt(ids)+parseInt(i*cnt);
        var idse = parseInt(idss)+cnt-1;

        if(parseInt(idse) > parseInt(ide))
        {
            idse = ide;
        }
        $.ajax({
            type: 'POST',
            async: false,
            url: SITE_DIR + 'include/ajax/blank_excel_out.php',
            data: {
                arParams:params,
                filter:filter,
                idss:idss,
                idse:idse,
                step:i,
                cntSteps:cntSteps,
                file:file
            },
            success: function(data) {
                file = data;


            },
        });
    }

    var now = new Date();

    var dd = now.getDate();
    if (dd < 10) dd = '0' + dd;
    var mm = now.getMonth() + 1;
    if (mm < 10) mm = '0' + mm;
    var hh = now.getHours();
    if (hh < 10) hh = '0' + hh;
    var mimi = now.getMinutes();
    if (mimi < 10) mimi = '0' + mimi;
    var ss = now.getSeconds();
    if (ss < 10) ss = '0' + ss;

    var rand = 0 - 0.5 + Math.random() * (999999999 - 0 + 1)
    rand = Math.round(rand);

    var name = 'blank_' + now.getFullYear() + '_' + mm + '_' + dd + '_' + hh + '_' + mimi + '_' + ss + '_' + rand + '.xlsx';

    var link = document.createElement('a');
    link.setAttribute('href',file);
    link.setAttribute('download',name);
    var event = document.createEvent("MouseEvents");
    event.initMouseEvent(
        "click", true, false, window, 0, 0, 0, 0, 0
        , false, false, false, false, 0, null
    );
    link.dispatchEvent(event);
    BX.closeWait();
}

function changeInput(_this)
{
    var OfferPrice = Number(_this.closest(".sizes-block-cnt").attr('data-price'));
    var id = Number(_this.closest(".sizes-block-cnt").attr('data-id'));
    var iblock = Number(_this.closest(".sizes-block-cnt").attr('data-iblock'));
    var value = _this.val();
    if (value >= 0)
    {
        $.ajax({
            type: 'POST',
            url: SITE_DIR + 'include/ajax/blank_ids.php',
            data: {
                'id': id,
                'qnt': value,
                'price': OfferPrice,
                'iblock':iblock
            },
            success: function (data)
            {
                if (data)
                {
                    var qnt = 0;
                    var price = 0;
                    var arr = JSON.parse(data);
                    for (key in arr)
                    {
                        qnt += parseInt(arr[key]['QNT']);
                        price += parseFloat(arr[key]['PRICE']) * parseInt(arr[key]['QNT']);
                    }
                    if (qnt >= 0)
                    {
                        $("#modification-basket-qnt").html(qnt);
                    }
                    if (price.toString().indexOf('.') >= 0) price = price.toFixed(2);
                    $("#modification-basket-price").html(price);
                }
            },
        });
    }
}