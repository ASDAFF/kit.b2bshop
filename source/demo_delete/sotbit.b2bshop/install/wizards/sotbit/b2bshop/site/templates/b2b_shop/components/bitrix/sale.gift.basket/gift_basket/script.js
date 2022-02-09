(function( window, document, $, undefined) {
	window.msGiftBasket = function(arParams)
	{
		this.SITE_ID = "";
		this.COLOR_UL = "";
		this.COLOR_UL_HOR = "";
		this.ModifSizeCol = "";
		this.js_slider_pic_small="";
		this.PRODUCT_ID = "";
		this.DETAIL_PAGE_URL = "";
		this.isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		this.container = "";
		this.ul = "";
		this.li = "";
		this.currentUl = "";
		this.currentLi = "";
		this.classLiActive = "";
		this.classLiDesabled = "";
		this.classLiAvailable = "";
		this.imgContainer = "";
		this.priceContainer = "";
		this.availableContainer = "";
		this.quantityInput = "";
		this.arImage = "";
		this.TemplatePath = "";
		this.propColor = "";
		this.xmlID = "";
		this.main = "";
		this.offerID = 0;
		this.add_url = "";
		this.add_wish = "";
		this.add_subscribe = "";
		this.basket_url = "";
		this.wish_url = "";
		this.props_name = "";
		this.offerAvailable = "";
		this.forgot_select_description = "";
		this.contBasket = "";
		this.basketUrl = "";
		this.boolScrollBasket = false;
		this.boolLoadBasket = false;
		this.contPrevNext = "";
		this.contPrev = "";
		this.contNext = "";
		this.contSelectProps = "";
		this.this_ = this;

		if ('object' === typeof arParams)
		{
			this.SITE_ID = arParams.SITE_ID;
			this.COLOR_UL = arParams.COLOR_UL;
			this.COLOR_UL_HOR = arParams.COLOR_UL_HOR;
			this.js_slider_pic_small=arParams.js_slider_pic_small;
			this.PRODUCT_ID = arParams.PRODUCT_ID;
			this.offerID = arParams.OFFER_ID;
			this.DETAIL_PAGE_URL = arParams.DETAIL_PAGE_URL;
			this.container = arParams.gift+" "+arParams.prop+" "+arParams.child_prop;
			this.propimg = arParams.prop_img;
			this.ul = arParams.prop;
			this.li = arParams.child_prop;
			this.classLiActive = arParams.class_li_active;
			this.classLiDesabled = arParams.class_li_disable;
			this.classLiAvailable = arParams.class_li_available;
			this.imgContainer = arParams.image_container;

			this.priceContainer = arParams.main+" "+arParams.price_container;
			this.availableContainer = arParams.main+" "+arParams.available_container;
			this.quantityInput = arParams.main+" "+arParams.quantity_input;
			this.arImage = arParams.image;
			this.TemplatePath = arParams.TemplatePath;
			this.AddPictures = arParams.AddPictures;
			this.propColor = arParams.prop_color;
			this.main = arParams.main;
			this.add_url = arParams.add_url;
			this.add_wish = arParams.add_wish;
			this.add_subscribe = arParams.add_subscribe;
			this.basket_url = arParams.basket_url;
			this.wish_url = arParams.wish_url;
			this.subscribe_url = arParams.subscribe_url;

			this.form_subscribe = arParams.form_subscribe;
			this.text_subscribe = arParams.text_subscribe;
			this.submit_subscribe = arParams.submit_subscribe;

			this.props_name = arParams.props_name;
			this.offerAvailable = arParams.offer_available_id;

			this.forgot_select_description = arParams.forgot_select_description;
			this.contBasket = arParams.contBasket;
			this.basketUrl = arParams.basketUrl;
			this.contPrevNext = arParams.contPrevNext;
			this.contPrev = arParams.contPrev;
			this.contNext = arParams.contNext;
			this.contSelectProps = arParams.contSelectProps;


	        this.toggle = arParams.toggle;
			this.prices = arParams.prices;
			this.discountPrice = arParams.discountPrice;
			this.oldPrice = arParams.oldPrice;
			this.download = arParams.download;

		}
		
		this.destroy(this);
		this.init(this);
		this.counter(this);    
		
	};
    
	window.msGiftBasket.prototype.init = function(_this)
	{    

		$(document).on("click", _this.container, _this, _this.clickProp);
		
		$(document).on("mouseenter", _this.propimg, _this, _this.clickProp);
		$(document).on("click", _this.add_url, _this, _this.clickAddBasket);
		$(document).on("click", _this.add_wish, _this, _this.clickAddWish);
		$(document).on("click", _this.add_subscribe, _this, _this.clickAddSubscribe);
		$(document).on("click", _this.submit_subscribe, _this, _this.clickAddSubscribeEmail);

		$(document).on("click", _this.toggle, _this, _this.clickToggle);
        

		$(document).on("mouseenter", _this.add_url, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.add_wish, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.add_subscribe, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.submit_subscribe, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.contSelectProps, _this, _this.checkStringProps);

	};






	window.msGiftBasket.prototype.destroy = function()
	{

		
		$(document).off("click", this.container, this.clickProp);
		
		$(document).off("mouseenter", this.propimg, this.clickProp);

		$(document).off("click", this.add_url, this.clickAddBasket);
		$(document).off("click", this.add_wish, this.clickAddWish);
		$(document).off("click", this.add_subscribe, this.clickAddSubscribe);
		$(document).off("click", this.submit_subscribe, this.clickAddSubscribeEmail);

		$(document).off("click", this.toggle,  this.clickToggle);
		
		$(document).off("mouseenter", this.add_url, this.checkStringProps);
		$(document).off("mouseenter", this.add_wish, this.checkStringProps);
		$(document).off("mouseenter", this.add_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.submit_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.contSelectProps, this.checkStringProps);

	};
	
	
	window.msGiftBasket.prototype.clickToggle = function(e){
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	}; 
	
	
	window.msGiftBasket.prototype.checkStringProps = function(e)
	{

		_this = e.data;
		strTitle = "";
		cont_modal = $(this);
		if(_this.offerID<=0)
		{   
			bool = true;
			$(_this.ul).each(function(){
				if($(this).find(_this.classLiActive).length==0)
				{
					if(bool) strTitle += $(this).attr("title");
					else strTitle += ", "+$(this).attr("title");
					bool = false;
				}
			})
			if(!bool)
			{
				cont_modal.msTooltip({"class":"class_check_props", "message":BX.message("MS_JS_CATALOG_SELECT_PROP")+" "+strTitle, "is_hover":true, "timeOut" : true});
				return false;
			}
		}
		return true;


	};





	window.msGiftBasket.prototype.counter = function(_this){
		if(_this.SITE_ID=="" || _this.PRODUCT_ID=="") return false;
		path = '/bitrix/components/bitrix/catalog.element/ajax.php';
		params = {
			AJAX: 'Y',
			SITE_ID: _this.SITE_ID,
			PRODUCT_ID: _this.PRODUCT_ID,
			PARENT_ID: 0
		};
		BX.ajax.post(
			path,
			params,
			function(data){}
		);
	};

	window.msGiftBasket.prototype.clickAddBasket = function(e){
		e.preventDefault();
		_this = e.data;
		if(!_this.checkProps($(_this.add_url))) return false;
		
		_this.ProductId=$(this).closest('.one-item').data('id');
		
		url = _this.basket_url[_this.offerID[_this.ProductId]];
		
		//quan = $(_this.quantityInput).val();
		//if(typeof quan !="undefined")
			url += "&quantity=1";
		BX.ajax.loadJSON(
			url,
			"",
			_this.successBasket
		);
	};  

	window.msGiftBasket.prototype.clickAddWish = function(e){
		e.preventDefault();
		_this = e.data;
		_this.ProductId=$(this).closest('.one-item').data('id');
		
		if(!_this.checkProps($(_this.add_wish))) return false;
		url = _this.wish_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(
			url,
			"",
			_this.successWish
		);

	};
	window.msGiftBasket.prototype.clickAddSubscribe = function(e){
		e.preventDefault();
		_this.ProductId=$(this).closest('.one-item').data('id');
		
		_this = e.data;

		if(!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		
		
		BX.ajax.loadJSON(
			url,
			"",
			_this.successSubscribe
		);

	};

	window.msGiftBasket.prototype.clickAddSubscribeEmail = function(e){
		
		e.preventDefault();
		_this.ProductId=$(this).closest('.one-item').data('id');
		_this = e.data;

		

		ser = $('.one-item[data-id='+_this.ProductId+']').find('.subscribe_new_form').serialize();

		email = $('.one-item[data-id='+_this.ProductId+']').find('.subscribe_new_form input[type=text]').val();


		if(email=="") return false;
		if(!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		

		BX.ajax.loadJSON(
			url,
			ser+"&ajax_email=Y",
			_this.successSubscribeEmail
		);

	};

	window.msGiftBasket.prototype.mouseLeaveBasket = function(e){
		$(this).fadeOut(400,function(){
			$(this).remove();
		});
	};

	window.msGiftBasket.prototype.successBasket = function(data){
		if(data.STATUS=="OK")
		{
			location.reload();
			/*_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id='+_this.ProductId+']').find('.btn_add_basket_gift').msTooltip({"class":"class_basket", "message":BX.message("MS_JS_CATALOG_ADD_BASKET"), "is_hover":false, "timeOut" : false});
			if(_this.isMobile){
				_this.afterAddWish();
			}else{ 
				_this.afterAddBasket();
			}*/
		}
		else alert(data.MESSAGE);
	};

	window.msGiftBasket.prototype.successWish = function(data){
		if(data.STATUS=="OK")
		{
			location.reload();
			/*_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id='+_this.ProductId+']').find('.btn_add_wish_gift').msTooltip({"class":"class_wish", "message":BX.message("MS_JS_CATALOG_ADD_WISH"), "is_hover":false, "timeOut" : false});
			
			if(_this.isMobile){
				_this.afterAddWish();
			}else{
				_this.afterAddWish();
			}*/
		}
		else alert(data.MESSAGE);
	};

	window.msGiftBasket.prototype.successSubscribe = function(data){
		if(data.STATUS=="OK")
		{
			location.reload();
			/*_this.boolLoadBasket = false;
			_this.boolScrollBasket = false; 
			$('.one-item[data-id='+_this.ProductId+']').find('.subscribe_product_form .back_call_submit').msTooltip({"class":"class_wish", "message":BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"), "is_hover":false, "timeOut" : false});
			if(_this.isMobile){
				_this.afterAddWish();
			}else{
				_this.afterAddWish();
			}*/
		}
		else alert(data.MESSAGE);
	};

	window.msGiftBasket.prototype.successSubscribeEmail = function(data){
		if(data.STATUS=="OK")
		{
			location.reload();
			/*_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id='+_this.ProductId+']').find('.subscribe_new_form input[type=submit]').msTooltip({"class":"class_wish", "message":BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"), "is_hover":false, "timeOut" : false});
			if(_this.isMobile){
				_this.afterAddWish();
			}else{
				_this.afterAddWish();
			}*/
		}
		else alert(data.MESSAGE);
	};

	window.msGiftBasket.prototype.afterAddBasket = function(){
		_this = this;
		//ser = $(_this.contBasket).serialize();
		//$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate( { scrollTop: 0 }, 1000);
		
		$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate( { scrollTop: 0 }, 1000,function(){BX.onCustomEvent('OnBasketChange');});
		
		
		//_this.boolLoadBasket = true;
		//$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate( { scrollTop: 0 }, 1000, _this.scrollTopEnd);
		
		/*BX.ajax.post(
			_this.basketUrl,
			ser+"&offerID="+_this.offerID,
			_this.afterSuccesBasket
		);*/
	};

	window.msGiftBasket.prototype.afterAddBasketMobile = function(){
		_this = this;
		//ser = $(_this.contBasket).serialize();
		BX.onCustomEvent('OnBasketChange');

		//$('html').animate( { scrollTop: 0 }, 1000, _this.scrollTopEnd);
		/*BX.ajax.post(
			_this.basketUrl,
			ser+"&offerID="+_this.offerID,
			_this.afterSuccesBasket
		);*/
	};

	window.msGiftBasket.prototype.afterAddWish = function(){
		_this = this;
		//BX.onCustomEvent('OnBasketChange');
		//ser = $(_this.contBasket).serialize();
		//$('html').animate( { scrollTop: 0 }, 1000, _this.scrollTopEnd);
		/*BX.ajax.post(
			_this.basketUrl,
			ser+"&offerID="+_this.offerID,
			_this.afterSuccesBasket
		);*/
	};

	window.msGiftBasket.prototype.afterSuccesBasket = function(data){
		
		_this.boolLoadBasket = true;
		if(data=="") return false;
		
		$(_this.contBasket).children().remove();
		//$(_this.contBasket).html(data);
		$(_this.contBasket).unbind("mouseleave");
		var h_basket = $(_this.contBasket).innerHeight()+"px";
		$(".window_basket").css("top", h_basket);
		$(_this.contBasket+" .window_basket").hide();
		if(_this.boolScrollBasket)
		{
			//$(_this.contBasket+" .window_basket").css('display','block');
			$(_this.contBasket+" .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
		//modal_basket_event()
		//modal_windows_close();
	};


	window.msGiftBasket.prototype.scrollTopEnd = function(){
		
		_this.boolScrollBasket = true;
		if(_this.boolLoadBasket)
		{
			$(_this.contBasket+" .window_basket").slideDown(1000, _this.scrollSlideEnd);

		}
	}; 

	window.msGiftBasket.prototype.scrollSlideEnd = function(){
		time = setTimeout(function(){
			$(_this.contBasket+" .window_basket").fadeOut(500, function(){$(this).remove()});

			}, 5000);
		$(document).on("mouseenter", _this.contBasket+" .window_basket", function(){
			clearInterval(time);  
			time = setTimeout(function(){
				$(_this.contBasket+" .window_basket .basket-item").slideDown(500);
				}, 2000);
		});
		$(_this.contBasket+" .window_basket").on("mouseleave", _this.mouseLeaveBasket);

	};

	window.msGiftBasket.prototype.checkProps = function(cont_modal){
		_this = this;
		if(_this.offerID[_this.ProductId]<=0)
		{   
			bool = true;
			$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(){
				if($(this).find(_this.classLiActive).length==0)
				{
					bool = false;
				}
			})
			if(!bool)
			{
				return false;
			}
		}
		return true;
	};

	window.msGiftBasket.prototype.clickProp = function(e){ 
		_this = e.data;

		
		if($(this).is(_this.classLiDesabled)) return false;

		/*if($(this).is(_this.classLiAvailable))
		{
			$('.subscribe_cont').show();
			$('.detail_block_price_cont').hide();
		}else{
			$('.detail_block_price_cont').show();
			$('.subscribe_cont').hide();
		}*/

		xmlID = $(this).attr("data-xml");

		
		_this.currentLi = $(this);
		_this.parent = $(this).parents(_this.ul).eq(0);
		
		
		_this.ProductId=$(this).closest('.one-item').data('id');
		_this.currentUl = $(_this.ul).index(_this.parent);
		_this.calculate();
		
		_this.calculateAvailable();
		_this.calculateID();
		_this.calculateAvailableBlock();
		_this.calculatePrice();
		

		return false;
	};

	window.msGiftBasket.prototype.calculate = function(){
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		
		
		$(_this.currentLi).closest('ul').find('.li-active').removeClass("li-active");
		$(_this.currentLi).not('.li-disable').not('.li-active').addClass("li-active");
		
		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(i, v){
			
			if(typeof arVarPrev !="undefined" && arVarPrev.length>0)
			{
				
				$(this).find(_this.li).each(function(){
					$(this).removeClass("li-disable");
					
					arOfferAttr = $(this).attr("data-offer").split(",");
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					
					if(erEmpty.length==0)
					{
						$(this).addClass("li-disable");
						$(this).removeClass("li-active");
						$(this).removeClass("li-available");
					}
				})
			}
			if(typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer")=="undefined")
			{

			}else{
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}

			
			if(typeof arVarPrev =="undefined" || arVarPrev.length==0){
				arVarPrev = arVarCur;
			}
			else{
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}

		})

	};

	window.msGiftBasket.prototype.calculateAvailable = function(){
		_this = this;

		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		offerAvailable = _this.offerAvailable;

		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(i, v){

			if(typeof arVarPrev !="undefined" && arVarPrev.length>0)
			{
				
				$(this).find(_this.li).not(".li-disable").each(function(){
					$(this).removeClass("li-available");
					arOfferAttr = $(this).attr("data-offer").split(",");
					arOfferAttr = arOfferAttr.filter(function(n) {
						if(typeof offerAvailable[n] =="undefined")
							return true;
						else return false;
					});

					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});

					if(erEmpty.length==0)
					{
						$(this).addClass("li-available");
					}
				});
				//START OFFER_PROPS

				AllCnt=$(this).find(_this.li).length;
				
				
				OtherCnt=$(this).find(_this.li).not(".li-active").length;

				if(AllCnt-OtherCnt==0)
				{
					
					$(this).find(_this.li).not(".li-disable").first().trigger('click');
					return false;
				}
				//END OFFER_PROPS
		}
			if(typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer")=="undefined")
			{

			}else{
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}

			if(typeof arVarPrev =="undefined" || arVarPrev.length==0){
				arVarPrev = arVarCur;
			}
			else{
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}

		})

	};


	window.msGiftBasket.prototype.calculateID = function(){
		_this = this;
		
		arOffer = $(_this.currentLi).closest('.one-item').find(_this.ul).eq(0).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
		
		
		
		countUl = $(_this.ul).length;
		countLi = $(_this.ul).find(_this.classLiActive).length;
		if(countUl!=countLi)
		{
			_this.offerID[_this.ProductId] = 0;
			return false;
		}

		
		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(){
			_this.offerID[_this.ProductId] = 0;
			
			
			$(this).find(_this.classLiActive).each(function(){
				arAttrOffer = $(this).attr("data-offer").split(",");

				$.each(arOffer, function(i, v){
					if($.inArray(v, arAttrOffer)==-1) delete arOffer[i];
					else _this.offerID[_this.ProductId] = v;
				})
			});
			//$(_this.main+" [name=PRODUCT_ID]").val(_this.offerID);
		})

	};

	window.msGiftBasket.prototype.calculateAvailableBlock = function(){
		_this = this;
		
		if(_this.offerID[_this.ProductId] && typeof _this.offerID[_this.ProductId] !="undefined")
		{
			offerAvailable = _this.offerAvailable;
			
			if(typeof offerAvailable[_this.offerID[_this.ProductId]] !="undefined")
			{
				$('.one-item[data-id='+_this.ProductId+']').find('.subscribe_cont').show();
				$('.one-item[data-id='+_this.ProductId+']').find('.detail_block_price_cont').hide();
			}else{
				$('.one-item[data-id='+_this.ProductId+']').find('.subscribe_cont').hide();
				$('.one-item[data-id='+_this.ProductId+']').find('.detail_block_price_cont').show();
			}
		}
	}

	window.msGiftBasket.prototype.calculatePrice = function(){
	
		
		if(this.offerID[this.ProductId]>0)
		{
			
			$(_this.currentLi).closest('.one-item').find(this.discountPrice).text(this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"]);
            if(this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"]!=this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]) 
           	 	{
            		$(_this.currentLi).closest('.one-item').find(this.oldPrice).text(this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]);
           	 	}
           	else
           		$(_this.currentLi).closest('.one-item').find(this.oldPrice).text('');
		}    
	};

})(window, document, jQuery);
