function BitrixSmallCart(){}

BitrixSmallCart.prototype = {

	activate: function ()
	{
		this.addBask=false;
		this.prods = [];
		this.cartElement = BX(this.cartId);
		this.fixedPosition = this.arParams.POSITION_FIXED == 'Y';
		if (this.fixedPosition)
		{
			this.cartClosed = true;
			this.maxHeight = false;
			this.itemRemoved = false;
			this.verticalPosition = this.arParams.POSITION_VERTICAL;
			this.horizontalPosition = this.arParams.POSITION_HORIZONTAL;
			this.topPanelElement = BX("bx-panel");
			this.OldCnt=0;
			this.NewCnt=0;

			this.fixAfterRender(); // TODO onready
			this.fixAfterRenderClosure = this.closure('fixAfterRender');

			var fixCartClosure = this.closure('fixCart');
			this.fixCartClosure = fixCartClosure;



			if (this.topPanelElement && this.verticalPosition == 'top')
				BX.addCustomEvent(window, 'onTopPanelCollapse', fixCartClosure);

			var resizeTimer = null;
			BX.bind(window, 'resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(fixCartClosure, 200);
			});
		}
		this.setCartBodyClosure = this.closure('setCartBody');
		BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshCart', {}));
	},

	fixAfterRender: function ()
	{
		this.statusElement = BX(this.cartId + 'status');
		if (this.statusElement)
		{
			if (this.cartClosed)
				this.statusElement.innerHTML = this.openMessage;
			else
				this.statusElement.innerHTML = this.closeMessage;
		}
		this.productsElement = BX(this.cartId + 'products');
		this.fixCart();
	},

	closure: function (fname, data)
	{
		var obj = this;
		return data
		? function(){obj[fname](data)}
		: function(arg1){obj[fname](arg1)};
	},

	toggleOpenCloseCart: function (action)
	{
		if(action=="open")
			this.cartClosed=true;
		else
			this.cartClosed=false
		if (this.cartClosed)
		{
			BX.removeClass(this.cartElement, 'bx-closed');
			BX.addClass(this.cartElement, 'bx-opener');
			BX.addClass(this.cartElement, 'bx-max-height');
			if(this.addBask)
				$('.window-without-bg').css('display','none');
			else
				$('.window-without-bg').css('display','block');
			//this.statusElement.innerHTML = this.closeMessage;
			this.cartClosed = false;
			this.fixCart();
		}
		else // Opened
		{
			$('.window-without-bg').slideUp(1000);
			BX.addClass(this.cartElement, 'bx-closed');
			BX.removeClass(this.cartElement, 'bx-opener');
			BX.removeClass(this.cartElement, 'bx-max-height');
			//this.statusElement.innerHTML = this.openMessage;
			this.cartClosed = true;
			var itemList = this.cartElement.querySelector("[data-role='basket-item-list']");
			
			//if (itemList)
			//	itemList.style.top = "auto";
		}
		setTimeout(this.fixCartClosure, 100);
	},

	setVerticalCenter: function(windowHeight)
	{
		var top = windowHeight/2 - (this.cartElement.offsetHeight/2);
		if (top < 5)
			top = 5;
		this.cartElement.style.top = top + 'px';
	},

	fixCart: function()
	{
		if(this.addBask)
			{
				//$("html:not(:animated)"+( ! $.browser.opera ? ",body:not(:animated)" : "")).animate( { scrollTop: 0 }, 1000,function(){$('.window-without-bg').slideDown(1000);});
				$('.window-without-bg').slideDown(1000);
			}
		// set horizontal center
		if (this.horizontalPosition == 'hcenter')
		{
			var windowWidth = 'innerWidth' in window
			? window.innerWidth
			: document.documentElement.offsetWidth;
			var left = windowWidth/2 - (this.cartElement.offsetWidth/2);
			if (left < 5)
			left = 5;
			this.cartElement.style.left = left + 'px';
		}

		var windowHeight = 'innerHeight' in window
		? window.innerHeight
		: document.documentElement.offsetHeight;

		// set vertical position
		switch (this.verticalPosition) {
			case 'top':
				if (this.topPanelElement)
					this.cartElement.style.top = this.topPanelElement.offsetHeight + 5 + 'px';
				break;
			case 'vcenter':
				this.setVerticalCenter(windowHeight);
				break;
		}

		// toggle max height
		if (this.productsElement)
		{
			var itemList = this.cartElement.querySelector("[data-role='basket-item-list']");
			if (this.cartClosed)
			{
				if (this.maxHeight)
				{
					BX.removeClass(this.cartElement, 'bx-max-height');
					if (itemList)
						itemList.style.top = "auto";
					this.maxHeight = false;
				}
			}
			else // Opened
			{
				if (this.maxHeight)
				{
					if (this.productsElement.scrollHeight == this.productsElement.clientHeight)
					{
						BX.removeClass(this.cartElement, 'bx-max-height');
						if (itemList)
							itemList.style.top = "auto";
						this.maxHeight = false;
					}
				}
				else
				{
					if (this.verticalPosition == 'top' || this.verticalPosition == 'vcenter')
					{
						if (this.cartElement.offsetTop + this.cartElement.offsetHeight >= windowHeight)
						{
							BX.addClass(this.cartElement, 'bx-max-height');
							if (itemList)
								itemList.style.top = 82+"px";
							this.maxHeight = true;
						}
					}
					else
					{
						if (this.cartElement.offsetHeight >= windowHeight)
						{
							BX.addClass(this.cartElement, 'bx-max-height');
							if (itemList)
								itemList.style.top = 82+"px";
							this.maxHeight = true;
						}
					}
				}
			}

			if (this.verticalPosition == 'vcenter')
				this.setVerticalCenter(windowHeight);
		}
	},

	refreshCart: function (data)
	{
		if (this.itemRemoved)
		{
			this.itemRemoved = false;
			return;
		}
		this.OldCnt=$(".modal-content .item-bg-1").length;
		
		var prods = this.prods;
		
		$(".modal-content .item-bg-1").each(function(index, element)
		{
			prods.push($(this).data('prod'));
		});
		this.prods = prods;
		if(data.sbblRemoveItemFromCart!="undefined" && data.sbblRemoveItemFromCart>0)
		{
			//delete
			this.addBask=false;
		}
		else
		{
			//addBasket
			this.addBask=true;
		}

		data.sessid = BX.bitrix_sessid();
		data.siteId = this.siteId;
		data.templateName = this.templateName;
		data.arParams = this.arParams;
		BX.ajax({
			url: this.ajaxPath,
			method: 'POST',
			dataType: 'html',
			data: data,
			onsuccess: this.setCartBodyClosure
		});
	},
	setCartBody: function (result)
	{
        if (this.cartElement)
            this.cartElement.innerHTML = result;
        if (this.fixedPosition)
            setTimeout(this.fixAfterRenderClosure, 100);
        //this.NewCnt==$(".modal-content .item-bg-1").length;


        var prods = this.prods;
        var NewCnt = 0;

        $(".modal-content .item-bg-1").each(function(index, element)
        {
            NewCnt+=1;
            if(prods.indexOf($(this).data('prod')) == -1)
            {
                $(this).show();
            }
        });
        if(NewCnt > this.OldCnt)
        {
            $('.modal-block_basket .basket-item-img').show();
            this.toggleOpenCloseCart("open");
        }
	},

	removeItemFromCart: function (id)
	{
		this.refreshCart ({sbblRemoveItemFromCart: id});
		this.itemRemoved = true;
		BX.onCustomEvent('OnBasketChange');
	}
	
};
