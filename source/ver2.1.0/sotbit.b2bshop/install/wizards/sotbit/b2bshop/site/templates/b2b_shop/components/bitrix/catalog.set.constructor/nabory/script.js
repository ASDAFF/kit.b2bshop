/*(function( window, document, $, undefined) {
	window.msDetailNabor = function(arParams)
	{
		this.SITE_ID = "";
		this.jsId= "";
		this.parentContId= "";
		this.ajaxPath= "";
		this.currency= "";
		this.mainElementPrice= "";
		this.mainElementOldPrice= "";
		this.mainElementDiffPrice= "";
		this.mainElementBasketQuantity= "";
		this.lid= "";
		this.iblockId= "";
		this.basketUrl= "";
		this.setIds= "";
		this.offersCartProps= "";
		this.itemsRatio= "";
		this.toggle= "";
		this.this_ = this;

		if ('object' === typeof arParams)
		{
			this.SITE_ID = arParams.SITE_ID;
			this.jsId = arParams.jsId;
			
			this.parentContId = arParams.parentContId;
			this.ajaxPath = arParams.ajaxPath;
			this.currency = arParams.currency;
			this.mainElementPrice = arParams.mainElementPrice;
			this.mainElementOldPrice = arParams.mainElementOldPrice;
			this.mainElementDiffPrice = arParams.mainElementDiffPrice;
			this.mainElementBasketQuantity = arParams.mainElementBasketQuantity;
			this.lid = arParams.lid;
			this.iblockId = arParams.iblockId;
			this.basketUrl = arParams.basketUrl;
			this.setIds = arParams.setIds;
			this.offersCartProps = arParams.offersCartProps;
			this.itemsRatio = arParams.itemsRatio;
			this.toggle = arParams.toggle;
			this.NaborAddBasket=this.parentContId+' .nabor-basket-botton';
			this.check=this.parentContId+' .check';
			this.Scroll=this.parentContId+' #nabor-scroll';
		}


		//this.destroy(this);
		this.init(this);
		//this.counter(this);    
		
	};
    
	window.msDetailNabor.prototype.init = function(_this)
	{    
		$(document).on("click", _this.check, _this, _this.clickCheckNabor);
		$(document).on("click", _this.toggle, _this, _this.clickToggle);
        $(document).one("mouseenter", _this.Scroll, _this, _this.SafariNaborScroll);
        $(document).one("touchstart", _this.Scroll, _this, _this.SafariNaborScrollPhone);
		$(document).on("click", _this.NaborAddBasket, _this, _this.clickNaborAddBasket);
	};
	
	window.msDetailNabor.prototype.clickToggle = function(e){
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};  
	
	
	
	window.msDetailNabor.prototype.SafariNaborScroll = function(e){
		_this = e.data;
		if($.browser.safari)
		{

					$(this).tinyscrollbar({ axis: "x"});

		} 
	};

	window.msDetailNabor.prototype.SafariNaborScrollPhone = function(e){
		_this = e.data;
		if($.browser.safari)
		{

					var $scrollbar = $(this);
					$scrollbar.tinyscrollbar({ axis: "x"});
					var scrollbar = $scrollbar.data("plugin_tinyscrollbar");
					scrollbar.update(50);

		} 
	};
	
window.msDetailNabor.prototype.clickCheckNabor = function(e){
	_this = e.data;
	
	
	var id=$(this).closest('.nabor-item').data('id');
	
	if($(this).closest('.nabor-item').hasClass('ibuy'))//del
	{
		$(this).html('');
		$(this).closest('.nabor-item').removeClass('ibuy');
		for (i = 0, l = _this.setIds.length; i < l; i++)
		{
			if (_this.setIds[i] == id)
				_this.setIds.splice(i, 1);
		}
	}
	else//add
	{
		$(this).html('<i class="fa fa-check" aria-hidden="true"></i>');
		$(this).closest('.nabor-item').addClass('ibuy');
		_this.setIds.push(id);
	}
	

	//recount
	var ElementSum=_this.mainElementPrice*_this.mainElementBasketQuantity;
	var ElementOldSum = _this.mainElementOldPrice*_this.mainElementBasketQuantity;
	
	var ItemsSum=0;
	var ItemsOldSum=0;
	
	$(_this.parentContId).find('.ibuy').each(
	function (index, value) { 
		ItemsSum=ItemsSum+($(this).data('price')*$(this).data('quantity'));
	});

	
	var AllSum=ElementSum+ItemsSum;
	var AllOldSum=ElementOldSum+ItemsOldSum;
	
	$(_this.parentContId).find('#nabor-basket-price').html(BX.Currency.currencyFormat(AllSum, _this.currency, true));
	
};


window.msDetailNabor.prototype.clickNaborAddBasket = function(e){
	e.preventDefault();
	_this = e.data;

	
	BX.ajax.post(
			_this.ajaxPath,
			{
				sessid: BX.bitrix_sessid(),
				action: 'catalogSetAdd2Basket',
				set_ids: _this.setIds,
				lid: _this.lid,
				iblockId: _this.iblockId,
				setOffersCartProps: _this.offersCartProps,
				itemsRatio: _this.itemsRatio
			},
			BX.proxy(function(result)
			{
				BX.closeWait();
				$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate( { scrollTop: 0 }, 1000,BX.onCustomEvent('OnBasketChange'));
			}, this)
		);
};  




})(window, document, jQuery);
	




$( document ).ready(function() {

	if($.browser.safari)
	{
		var MainHeight=$('.nabor-main').find('img').attr('height');
		var NewHeight=parseInt(MainHeight)+50;
		$('#nabor-scroll').height(NewHeight);
	}
	if(Math.abs($('#nabor-scroll .thumb').width()-$('#nabor-scroll .track').width())<10)
	{
		$('#nabor-scroll .scrollbar').hide();
	}
});*/