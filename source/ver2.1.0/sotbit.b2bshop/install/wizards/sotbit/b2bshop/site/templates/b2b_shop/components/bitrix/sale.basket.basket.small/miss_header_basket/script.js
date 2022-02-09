(function( $ ) {
    $.fn.msBasketCart = function(options) {
        var _this = this;
        var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
        var mainClass = "";
        var dopClass = "";
        var basketUrl = "";
        var basketItem = "";
        var deleteBasket = "";
        var itemCont = "";
        var boolHover = false;

        var methods = {
            init : function(){
                if(isMobile)
                    return false;
                _this.on("click", "a", this.clickBasket);
                _this.on("mouseenter", "a", this.hoverBasket);
                _this.on("mouseleave", this.mouseLeaveBasket);
                _this.on("click", deleteBasket, this.clickDeleteBasket); 
            },
            clickBasket : function(e){
                if(isMobile) {
                    e.preventDefault();
                }
            },
            hoverBasket : function(e){
                if(_this.find(mainClass).length) return;
                boolHover = true;
                setTimeout(function(){
                    if(boolHover)methods.doAjax();    
                }, 800)
                

            },
            mouseLeaveBasket : function(e){
                boolHover = false;
                if(_this.find(mainClass).length) {
                    _this.find(mainClass).slideUp(1000,function(){
                        $(this).remove();
                    });
                }
            },
            doAjax : function(){
                ser = _this.serialize();
                BX.ajax.post(
			        basketUrl,
			        ser,
			        methods.successBasket
		        );
            },
            successBasket : function(data){
                if(data=="") return false;
                _this.children().remove();
                _this.html(data);
                var h_basket = _this.innerHeight()+"px";
                $(".window_basket").css("top", h_basket);
                modal_basket_event()
                modal_windows_close();
            },
            clickDeleteBasket : function(e){
                e.preventDefault();
                itemCont = $(this).parents(basketItem);
                id = itemCont.attr("data-id");
                ser = _this.serialize();
                BX.ajax.post(
			        basketUrl,
			        "ajax_delete_basket="+id+"&"+ser,
			        methods.successBasket
		        );
            },
            successDeleteBasket : function(data){
                if(data.STATUS=="OK")
                {
                    itemCont.remove();
                }else alert(data.MESSAGE)
            }

        }

        return this.each(function() {
            mainClass = options["mainClass"];
            dopClass = options["dopClass"];
            basketUrl = options["basketUrl"];
            basketItem = options["basketItem"];
            deleteBasket = options["deleteBasket"];
            methods.init();
        })

    }
})(jQuery);