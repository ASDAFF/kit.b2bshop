(function($) {
	$.fn.msTooltip = function(options) {
		var this_ = this;
		var class_ = "";
		var is_hover = false;
		var content = "";
		var hoverBool = true;
		var timeOut = false;
		var methods = {
			init: function() {
				if (timeOut) setTimeout(this.openModal, 500);
				else this.openModal();
				this_.on("mouseleave", function() {
					hoverBool = false;
				})
			},
			openModal: function() {
				if (!hoverBool && timeOut) return false;
				var class_modal = "." + class_;
				var boolHover = false;
				$(".miss_small_modal").remove();
				if (!$(class_modal).length) {
					var block = "<span class='miss_small_modal bootstrap_style " + class_ + "'><span class='wrap_text'>" + content + "</span></span>";
					if (this_.is("input")) this_ = this_.parent();
					this_.append(block);
					var height_modal = $(class_modal).height();
					var position = this_.offset();
					$(document).on("click", class_modal, function(e) {
						e.preventDefault();
						$(this).fadeOut(400, function() {
							$(this).remove();
						});
						return false;
					})
					$(class_modal).css({
						'margin-top': -height_modal
					});
					$(class_modal).animate({
						opacity: 1
					}, 400);
					if (is_hover) {
						$(document).on("mouseleave", "." + this_.attr("class"), function(e) {
							$(class_modal).fadeOut(400, function() {
								$(class_modal).remove();
							});
						})
					} else setTimeout(function() {
						$(class_modal).fadeOut(400, function() {
							$(class_modal).remove();
						});
					}, 4000);
				}
			},
		}
		return this.each(function() {
			class_ = options["class"];
			is_hover = options["is_hover"];
			content = options["message"];
			timeOut = options["timeOut"];
			methods.init();
		})
	}
	//$('body').click(function(event){console.log(event.target);});
})(jQuery);
/////////////SECTION/////////////
(function(window, document, $, undefined) {
	var arImage = "";
	var arSizes = "";
	var listBlock = "";
	var currentOffers = "";
	var listItem = "";
	var listItemSmalImg = "";
	var mainItem = "";
	var mainItemImage = "";
	var btn_class = "";
	var bigData = false;
	var boolOut = false;
	window.msListProduct = function(arParams) {
		this.arImage = arParams["arImage"];
		this.quantity = arParams["quantity"];
		this.offerAvailable = arParams.offer_available_id;
		this.currentOffers = arParams.currentOffers;
		this.articles = arParams.articles;
		this.basket_url = arParams.basket_url;
		this.arSizes = arParams["sizes"];
		this.listBlock = arParams["listBlock"];
		this.listItem = arParams["listItem"];
		this.listItemSmalImg = arParams["listItemSmalImg"];
		this.mainItemImage = arParams["mainItemImage"];
		this.listItemOpen = arParams["listItemOpen"];
		this.bigData = arParams["bigData"];
		this.ul = arParams.prop;
		this.quantityInput = arParams.quantityInput;
		this.basketWrapper = arParams.basketWrapper;
		this.li = arParams.child_prop;
		this.classLiActive = arParams.class_li_active;
		this.classLiDesabled = arParams.class_li_disable;
		this.classLiAvailable = arParams.class_li_available;
		this.mainItem = this.listBlock + " " + this.listItem;
		this.mainItemSmalImg = this.mainItem + " " + this.listItemSmalImg;
		this.firstColor = new Array();
		this.current = new Array();
		this.container = "#section_list " + arParams.prop + " " + arParams.child_prop;
		this.basket = arParams.basketWrapper + " " + arParams.basket;
		this.lenArray = new Array();
		this.mouseX0 = this.mouseX1 = 0;
		this.currentBool = false;
		this.prices = arParams.prices;
		this.boolDown = false;
		this.btnLeft = arParams["btnLeft"];
		this.btnRight = arParams["btnRight"];
		this.destroy();
		this.init();
		
	}
	window.msListProduct.prototype.destroy = function() {
		$(document).off("click touchstart", this.basket, this.clickAddBasket);
		$(document).off("click", this.mainItemSmalImg, this.clickSmallImg);
		$(document).off("click touchstart", this.container, this.clickProp);
		$(document).off("mouseover", this.mainItemSmalImg, this.clickSmallImg);
		$(document).off("mouseout", this.mainItemSmalImg, this.clickSmallImgOut);
		$(document).off("click", this.mainItem + " " + this.btnLeft, this.clickLeft);
		$(document).off("click", this.mainItem + " " + this.btnRight, this.clickRight);
		$(document).off("mousedown", this.mainItem + " " + this.listItemOpen, this.clickImageDown);
		$(document).off("click", this.mainItem + " " + this.listItemOpen, this.clickImage);
		$(this.mainItem).off("mouseup", this.clickImageUp);
		$(document).off("touchstart", this.mainItem + " " + this.listItemOpen, this.clickImageDownTouch);
		$(document).off("touchend", this.mainItem + " " + this.listItemOpen, this.clickImageUpTouch);

	}
	window.msListProduct.prototype.init = function()
	{
		if(typeof this.bigData === 'object')
		{
			if (this.bigData.enabled && BX.util.object_keys(this.bigData.rows).length > 0)
			{
				BX.cookie_prefix = this.bigData.js.cookiePrefix || '';
				BX.cookie_domain = this.bigData.js.cookieDomain || '';
				BX.current_server_time = this.bigData.js.serverTime;

				BX.ready(BX.proxy(this.bigDataLoad, this));
			}
		}


		if ($('#section_list').length && parseInt(window.innerWidth) < 768 && this.CntInRow != 0) {
			var items = new Array();
			var i = 0;
			$('#section_list .row').each(function() {
				$(this).children().each(function() {
					items[i] = $(this);
					++i;
				});
			});
			var newHTML = "";
			jQuery.each(items, function(i, val) {
				if (i % 2 == 0) {
					newHTML += '<div class="row">';
					newHTML += $(this).wrapAll('<div>').parent().html();
				} else {
					newHTML += $(this).wrapAll('<div>').parent().html();
					newHTML += '</div>';
				}
				$('#section_list').html(newHTML);
				$('#section_list').show();
			});
		}
		// one height of top part
		var MinHeight = 0;
		if ($('.owl-stage-outer', this.listBlock).length > 0) // if slider
		{
			var MinHeight = OneHeight($(this.listBlock));
			if (MinHeight > 100) {
				$('.one-item .item-top-part', this.listBlock).height(MinHeight);
			}
			var PaddingHeight = 125;
			var MinAddHeight = 0;
			var Add = 0;
			var OuterHeight = parseInt($('.owl-stage-outer').find( this.listBlock).height());
			$('.one-item .item_open', this.listBlock).each(function() {
				var Height = parseInt($(this).height());
				if (Height > OuterHeight) {
					var Add = Height - OuterHeight;
					if (Add > MinAddHeight) {
						MinAddHeight = Add;
					}
				}
			});
			if (MinAddHeight > 0) {
				PaddingHeight += MinAddHeight;
				$('.one-item', this.listBlock).css('padding-bottom', PaddingHeight);
			}
		} else {
			$('.row', this.listBlock).each(function() {
				var MinHeight = OneHeight($(this));
				if (MinHeight > 100) {
					$('.one-item .item-top-part', this).height(MinHeight);
				}
			});
		}

		$(document).on("click touchstart", this.container, this, this.clickProp);
		$(document).on("click touchstart", this.basket, this, this.clickAddBasket);
		$(document).on("click touchstart", '.plus', this, this.clickPlus);
		$(document).on("click touchstart", '.minus', this, this.clickMinus);
		$(document).on("mouseenter", ".one-item:not(.hover)", this, this.overOpenProduct);
		$(document).on("click", ".one-item:not(.hover)", this, this.overOpenProduct);
		$(document).on("click", this.mainItemSmalImg, this, this.clickSmallImg);
		$(document).on("mouseover", this.mainItemSmalImg, this, this.clickSmallImg);
		$(document).on("mouseout", this.mainItemSmalImg, this, this.clickSmallImgOut);
		$(document).on("click", this.mainItem + " " + this.btnLeft, this, this.clickLeft);
		$(document).on("click", this.mainItem + " " + this.btnRight, this, this.clickRight);
		$(document).on("mousedown", this.mainItem + " " + this.listItemOpen, this, this.clickImageDown);
		$(document).on("click", this.mainItem + " " + this.listItemOpen, this, this.clickImage);
		$(this.mainItem).on("mouseup", this, this.clickImageUp);
		$(document).on("touchstart", this.mainItem + " " + this.listItemOpen, this, this.clickImageDownTouch);
		$(document).on("touchend", this.mainItem + " " + this.listItemOpen, this, this.clickImageUpTouch);
	}

	window.msListProduct.prototype.clickPlus = function(e)
	{
		e.preventDefault();
		_this = e.data;

		_this.this_ = $(this);
		var wrapper = $(this).closest(_this.basketWrapper);

		var productId = wrapper.data('id');
		if(productId > 0)
		{
			var offerId = parseInt(_this.currentOffers[productId]);
		}

		if(offerId > 0)
		{
			var qntBlock = wrapper.find('.b2b__quantity__input');
			var qnt = parseInt(qntBlock.val());
			qnt = qnt + 1;
			qntBlock.val(qnt);


			var prices = _this.prices[offerId];

			var price = 0;

			$('.b2b__header__row-props__one-item[data-id="'+productId+'"] .b2b__header__props__prices').each(function(i, v)
			{
				if($(this).hasClass('b2b__header__props__prices__active'))
				{
					price = prices[i+1]['VALUE'];
				}
			});
			$.ajax({
				type: 'POST',
				url: SITE_DIR + 'include/ajax/blank_ids.php',
				data: {
					'id': offerId,
					'qnt': qnt,
					'price' : price
				},
				success: function(data) {
				},
			});
		}




	};



	window.msListProduct.prototype.clickMinus = function(e)
	{
		e.preventDefault();
		_this = e.data;

		_this.this_ = $(this);
		var wrapper = $(this).closest(_this.basketWrapper);

		var productId = wrapper.data('id');
		if(productId > 0)
		{
			var offerId = parseInt(_this.currentOffers[productId]);
		}

		if(offerId > 0)
		{
			var qntBlock = wrapper.find('.b2b__quantity__input');
			var qnt = parseInt(qntBlock.val());
			qnt = qnt - 1;

			if(qnt > 0)
			{
				qntBlock.val(qnt);
				$.ajax({
					type: 'POST',
					url: SITE_DIR + 'include/ajax/blank_ids.php',
					data: {
						'id': offerId,
						'qnt': qnt,
					},
					success: function(data) {
					},
				});
			}
		}
	};


	window.msListProduct.prototype.clickAddBasket = function(e)
	{
		e.preventDefault();
		_this = e.data;

		_this.this_ = $(this);
		var wrapper = $(this).closest(_this.basketWrapper);
		var productId = wrapper.data('id');

		url = _this.basket_url[_this.currentOffers[productId]];
		quan = wrapper.find(_this.quantityInput).val();
		if (typeof quan != "undefined") url += "&quantity=" + quan;
		BX.ajax.loadJSON(url, "", _this.successBasket);
	};


	window.msListProduct.prototype.successBasket = function(data)
	{
		if (data.STATUS == "OK")
		{
			_this.this_.addClass('success-added');
			var wrapper = _this.this_.closest(_this.basketWrapper);
			wrapper.find(_this.quantityInput).val(1);
			BX.onCustomEvent('OnBasketChange');
		}
		else alert(data.MESSAGE);
	};
	window.msListProduct.prototype.afterAddBasket = function() {
		_this = this;
	};
	window.msListProduct.prototype.afterAddBasketMobile = function() {
		_this = this;
		BX.onCustomEvent('OnBasketChange');
	};

	window.msListProduct.prototype.clickProp = function(e) {
		_this = e.data;

		if ($(this).is(_this.classLiDesabled)) return false;
		xmlID = $(this).attr("data-xml");
		_this.currentLi = $(this);
		_this.parent = $(this).parents(_this.ul).eq(0);
		_this.currentUl = _this.currentLi.closest('.b2b__header__props__value').find(_this.ul);
		_this.productRow = _this.currentLi.closest('.b2b__header__row-props__one-item');
		_this.productId = _this.productRow.data('id');

		$(_this.parent).each(function(i, v)
		{
			$(this).find('.li-active').removeClass('li-active')
		});
		$(this).addClass('li-active');

		_this.calculate();
		_this.calculateAvailable();
		_this.calculateID();
		_this.calculateAvailableBlock();
		_this.calculatePrice();
		return false;
	};


	window.msListProduct.prototype.calculate = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		_this.currentUl.each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).each(function() {
					$(this).removeClass("li-disable");
					arOfferAttr = $(this).attr("data-offer").split(",");
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-disable");
						$(this).removeClass("li-active");
						$(this).removeClass("li-available");
					}
				})
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msListProduct.prototype.calculateAvailable = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		offerAvailable = _this.offerAvailable;
		_this.currentUl.each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).not(".li-disable").each(function() {
					$(this).removeClass("li-available");
					arOfferAttr = $(this).attr("data-offer").split(",");
					arOfferAttr = arOfferAttr.filter(function(n) {
						if (typeof offerAvailable[n] == "undefined") return true;
						else return false;
					});
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-available");
					}
				});
				AllCnt = $(this).find(_this.li).length;
				OtherCnt = $(this).find(_this.li).not(".li-active").length;
				if (AllCnt - OtherCnt == 0) {
					$(this).find(_this.li).not(".li-disable").first().trigger('click');
					return false;
				}
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};

	window.msListProduct.prototype.calculateAvailableBlock = function()
	{
		_this = this;
		if (_this.offerID && typeof _this.offerID != "undefined")
		{
			offerAvailable = _this.offerAvailable;
			if (typeof offerAvailable[_this.offerID] != "undefined")
			{
				$('.b2b__header__name__' + _this.productId + ' .b2b__header__available').hide();
				$('.b2b__header__name__' + _this.productId + ' .b2b__header__no_available').show();
				$(_this.basketWrapper+'-'+_this.productId).hide();
			}
			else
			{
				$('.b2b__header__name__' + _this.productId + ' .b2b__header__available').show();
				$('.b2b__header__name__' + _this.productId + ' .b2b__header__no_available').hide();
				$(_this.basketWrapper+'-'+_this.productId).show();
				$('.b2b__header__name__' + _this.productId + ' .b2b__header__available__quantity').html('');
				if (typeof _this.quantity[_this.offerID] != "undefined")
				{
					$('.b2b__header__name__' + _this.productId + ' .b2b__header__available__quantity').html(' ('+BX.message("B2B_QUANTITY")+' '+_this.quantity[_this.offerID]+')');
				}
			}
		}
	};
	window.msListProduct.prototype.calculateID = function() {
		_this = this;

		arOffer = _this.currentUl.eq(0).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
		countUl = _this.currentUl.length;
		countLi = _this.currentUl.find(_this.classLiActive).length;
		if (countUl != countLi) {
			_this.offerID = 0;
			return false;
		}
		_this.currentUl.each(function() {
			_this.offerID = 0;
			$(this).find(_this.classLiActive).each(function() {
				arAttrOffer = $(this).attr("data-offer").split(",");
				$.each(arOffer, function(i, v) {
					if ($.inArray(v, arAttrOffer) == -1) delete arOffer[i];
					else _this.offerID = v;
				})
			});
		});
		_this.currentOffers[_this.productId] = _this.offerID;


		if(_this.articles[_this.offerID])
		{

			$('.b2b__header__name__' + _this.productId + ' .b2b__header__name__article_art').show();
			$('.b2b__header__name__' + _this.productId + ' .b2b__header__name__article_artval').html(_this.articles[_this.offerID]);
		}
		else
		{
			$('.b2b__header__name__' + _this.productId + ' .b2b__header__name__article_art').hide();
			$('.b2b__header__name__' + _this.productId + ' .b2b__header__name__article_artval').html();
		}

		BX.onCustomEvent('onCatalogStoreProductChange', [_this.offerID]);
	};
	window.msListProduct.prototype.calculatePrice = function()
	{

		if (this.offerID > 0 && this.prices[this.offerID])
		{
			var prices = this.prices[this.offerID];
			$.each( prices, function( index, value ){
				_this.productRow.find('.price-code-' + index).html(value['TEXT']);
			});
		}
	};

	window.msListProduct.prototype.overOpenProduct = function(e) {
		_this = e.data;
		this_ = $(this);
		var ID = $(this).data('id');
		var _thisBlock = $(this);
		if ($('.swiper-slide img', _thisBlock).length == 0 && _thisBlock.find('.big_img_js').attr('src') != '/upload/no_photo.jpg') {
			$.ajax({
				type: 'POST',
				url: SITE_DIR + 'include/ajax/open_product.php',
				data: {
					arImage: _this.arImage[ID],
					arSizes: _this.arSizes,
				},
				success: function(data) {
					if (data != '') {
						_this['arImage'][ID] = JSON.parse(data);
						var WrapperWidth = $('.swiper-wrapper', _thisBlock).width();
						var Colors = JSON.parse(data);
						$.each(Colors, function(i, img) {
							var NewHeight = img['SMALL'][0]['height'] / (img['SMALL'][0]['width'] / parseInt(WrapperWidth));
							if (parseInt(NewHeight) > img['SMALL'][0]['height']) NewHeight = img['SMALL'][0]['height'];
							_thisBlock.find("." + i + "-replace").css({
								"width": "auto",
								"height": NewHeight
							}).html('<img class="small-img-ajax" src="' + img['SMALL'][0]['src'] + '" width="' + img['SMALL'][0]['width'] + '" height="' + img['SMALL'][0]['height'] + '">');
						});
						do_swiper(_thisBlock);
						if($(_thisBlock).is(":hover"))
						{
							section_wrap_item_show(_thisBlock);
						}
					}
				},
			});
		} else {
			section_wrap_item_show(_thisBlock);
		}
	}
	window.msListProduct.prototype.clickImage = function(e) {
		_this = e.data;
		contParent = $(this).parents(_this.listItem);
		_this.mouseX1 = e.clientX;
		_this.boolDown = false;
		if (_this.calculateMouse(contParent)) {
			e.preventDefault();
			return false;
		}
	}
	window.msListProduct.prototype.clickImageDown = function(e) {
		e.preventDefault();
		_this = e.data;
		_this.boolDown = true;
		_this.mouseX0 = e.clientX;
	}
	window.msListProduct.prototype.clickImageDownTouch = function(e) {
		_this = e.data;
		var touches = _this.getTouches(e);
		var touch = touches[0];
		var pageX = touch.pageX;
		var pageY = touch.pageY;
		_this.boolDown = true;
		_this.mouseX0 = pageX;
	}
	window.msListProduct.prototype.clickImageUp = function(e) {
		e.preventDefault();
		_this = e.data;
		if (_this.boolDown) {
			_this.mouseX1 = e.clientX;
			_this.boolDown = false;
		}
	}
	window.msListProduct.prototype.clickImageUpTouch = function(e) {
		_this = e.data;
		var touches = _this.getTouches(e);
		var touch = touches[0];
		var pageX = touch.pageX;
		var pageY = touch.pageY;
		contParent = $(this).parents(_this.listItem);
		if (_this.boolDown) {
			_this.mouseX1 = pageX;
			_this.boolDown = false;
			_this.calculateMouse(contParent)
		}
	}
	window.msListProduct.prototype.getTouches = function(e) {
		if (e.originalEvent) {
			if (e.originalEvent.touches && e.originalEvent.touches.length) {
				return e.originalEvent.touches;
			} else if (e.originalEvent.changedTouches && e.originalEvent.changedTouches.length) {
				return e.originalEvent.changedTouches;
			}
		}
		if (!e.touches) {
			e.touches = new Array();
			e.touches[0] = e.originalEvent;
		}
		return e.touches;
	}
	window.msListProduct.prototype.calculateMouse = function(contParent) {
		if (this.mouseX1 - this.mouseX0 > 10) {
			this.clickRight(contParent);
			return true;
		} else if (this.mouseX1 - this.mouseX0 < -10) {
			this.clickLeft(contParent);
			return true;
		} else return false;
	}
	window.msListProduct.prototype.clickRight = function(e) {
		if (typeof e.selector == "undefined") {
			e.preventDefault();
			_this = e.data;
			conParent = $(this).parents(_this.listItem);
		} else {
			_this = this;
			conParent = e;
		}
		count = 0;
		ID = conParent.attr("data-id");
		if (typeof _this.current[ID] == "undefined" || _this.currentBool) {
			_this.current[ID] = 2;
		} else _this.current[ID]++;
		if (_this.current[ID] == 0) _this.current[ID] = 1;
		_this.calculateSlider(ID, conParent);
		_this.currentBool = false;
	}
	window.msListProduct.prototype.checkProps = function(cont_modal) {
		_this = this;
		if (_this.offerID <= 0) {
			bool = true;
			$(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					bool = false;
				}
			})
			if (!bool) {
				return false;
			}
		}
		return true;
	};
	window.msListProduct.prototype.clickLeft = function(e) {
		if (typeof e.selector == "undefined") {
			e.preventDefault();
			_this = e.data;
			conParent = $(this).parents(_this.listItem);
		} else {
			_this = this;
			conParent = e;
		}
		count = 0;
		ID = conParent.attr("data-id");
		if (typeof _this.current[ID] == "undefined" || _this.currentBool) {
			_this.current[ID] = -1;
		} else _this.current[ID]--;
		if (_this.current[ID] == 0) _this.current[ID] = -1;
		_this.calculateSlider(ID, conParent);
		_this.currentBool = false;
	}
	window.msListProduct.prototype.calculateSlider = function(ID, conParent) {
		if (typeof _this.firstColor[ID] == "undefined") {
			if (conParent.attr("data-first-color") == "undefined" || conParent.attr("data-first-color") == "") _this.firstColor[ID] = conParent.find(_this.listItemSmalImg).eq(0).attr("data-color");
			else _this.firstColor[ID] = conParent.attr("data-first-color");
		}
		if (typeof _this.lenArray[ID] == "undefined") {
			_this.lenArray[ID] = 0;
			$.each(_this.arImage[ID][_this.firstColor[ID]]["MEDIUM"], function(k, v) {
				_this.lenArray[ID]++;
			})
		}
		count = 0;
		if (_this.current[ID] > _this.lenArray[ID]) _this.current[ID] = 1;
		else if (_this.current[ID] < 0 && Math.abs(_this.current[ID]) > _this.lenArray[ID]) _this.current[ID] = -1;
		n = _this.current[ID] + _this.lenArray[ID] + 1;
		$.each(_this.arImage[ID][_this.firstColor[ID]]["MEDIUM"], function(k, v) {
			count++;
			if (_this.current[ID] > 0) {
				if (count == _this.current[ID]) {
					conParent.find(_this.mainItemImage).attr("src", v["src"]);
				}
			} else if (_this.current[ID] < 0) {
				if (n == count) {
					conParent.find(_this.mainItemImage).attr("src", v["src"]);
				}
			}
		})
	}
	window.msListProduct.prototype.clickSmallImgOut = function(e) {
		_this = e.data
		_this.boolOut = false;
	}
	window.msListProduct.prototype.clickSmallImg = function(e) {
		e.preventDefault();
		_this = e.data;
		_this.boolOut = true;
		conParent = $(this).parents(_this.listItem);
		ID = conParent.attr("data-id");
		_this.firstColor[ID] = color = $(this).attr("data-color");
		_this.currentBool = true;
		_this.lenArray = new Array();
		if (e.type == "mouseover") {
			setTimeout(second_passed(true), 300);
		} else {
			n = 0;
			_this.checkPrevNext(_this.arImage[ID][color]["MEDIUM"].length, conParent);
			$.each(_this.arImage[ID][color]["MEDIUM"], function(k, v) {
				n++;
				conParent.find(_this.mainItemImage).attr("src", v["src"]);
				return false;
			})
		}

		function second_passed(bool) {
			if (!bool) return false;
			n = 0;
			var MediumCnt = 0;
			$.each(_this.arImage[ID][color]["MEDIUM"], function(k, v) {
				MediumCnt++;
			})
			_this.checkPrevNext(MediumCnt, conParent);
			$.each(_this.arImage[ID][color]["MEDIUM"], function(k, v) {
				n++;
				conParent.find(_this.mainItemImage).attr("src", v["src"]);
				return false;
			})
		}
	}
	window.msListProduct.prototype.checkPrevNext = function(count, conParent) {
		if (count > 1) {
			conParent.find(this.btnLeft).show();
			conParent.find(this.btnRight).show();
		} else {
			conParent.find(this.btnLeft).hide();
			conParent.find(this.btnRight).hide();
		}
	}
})(window, document, jQuery);
///////////MENU////////
(function(window, document, $) {
	$.fn.mainMenu = function(options) {
		var settings = $.extend({
			'wrap-menu': '#' + this.attr("id"),
			'wrap-top-menu': '#wrap-main-top-menu',
			'inner-menu': '#wrap-top-inner-menu',
			'inner-slide-menu': '#slide-inner-menu',
			'inner-ul-1': '.menu-lv-2-2',
			'inner-ul-2': '.menu-lv-2-1',
			'wrap-btn-open-menu': '#open-mobile-menu',
			'btn-open-menu': '#open-menu',
			'menu-mobile': '#menu_mobile',
			'ShowMenuFadeSpeed': '400',
			'SlideMenuSpeed': '400',
			'OpenMenuTimeOut': '300'
		}, options);
		var objMenu = this;
		var slideInnerMenu = "";
		var activeItem = "";
		var timerLi_open = "";
		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		var methods = {
			init: function(options) {
				if (objMenu.is(":visible")) {
					methods.InnerMenuPosition();
				}
				$(settings["inner-slide-menu"]).owlCarousel({
					autoplay: false,
					autoplayTimeout: 5000,
					autoplayHoverPause: true,
					nav: false,
					navText: ["", ""],
					touchDrag: false,
					mouseDrag: false,
					items: 1,
					dots: false,
					smartSpeed: settings["SlideMenuSpeed"],
					onInitialized: function() {}
				});
				/*$('.Collage').collagePlus({
						'allowPartialLastRow' : true
				});*/
				slideInnerMenu = $(settings["inner-slide-menu"]).data('owlCarousel');
				if (isMobile) {
					$(document).on('click', settings["wrap-top-menu"] + ' li a', function() {
						if (!$(this).parents('li').hasClass('li-hover')) {
							return false;
						}
					});
					$(document).on('mouseenter touchstart', settings["wrap-top-menu"] + ' li a', function() {
						activeItem = $(this);
						methods.openMenu();
					});
				} else {
					$(document).on('mouseenter', settings["wrap-top-menu"] + ' li a', function() {
						activeItem = $(this);
						clearTimeout(timerLi_open);
						timerLi_open = setTimeout(function() {
							methods.openMenu();
						}, settings["OpenMenuTimeOut"]);
					});
					$(document).on('mouseenter', settings["inner-menu"], function() {
						clearTimeout(timerLi_open);
					});
					objMenu.on('mouseleave', function() {
						clearTimeout(timerLi_open);
					});
				}
				if ($(settings["wrap-btn-open-menu"]).is(":visible")) {
					methods.MobileMenuCreate();
				};
				$(window).bind("resize", function() {
					if (objMenu.is(":visible")) {
						methods.InnerMenuPosition();
					}
					if ($(settings["wrap-btn-open-menu"]).is(":visible")) {
						methods.MobileMenuCreate();
					};
				});
			},
			InnerMenuPosition: function(options) {
				$(settings["inner-menu"] + " .item").css("position", "relative");
				var height_menu = $(settings["wrap-top-menu"]).height();
				var top_inner_menu = height_menu + 5;
				$(settings["inner-menu"]).css('top', top_inner_menu);
			},
			openMenu: function(options) {
				var thisIndex = activeItem.data('index');
				if (thisIndex == "0" || thisIndex) {
					$(settings["wrap-top-menu"] + ' li.li-hover').removeClass('li-hover');
					if (isMobile) {
						setTimeout(function() {
							activeItem.parents('li').addClass('li-hover');
						}, 200);
					} else {
						activeItem.parents('li').addClass('li-hover');
					}
					var owl = $('#slide-inner-menu');
					if ($(settings["inner-menu"]).css('visibility') == "hidden") {
						owl.trigger("to.owl.carousel", [thisIndex, 1, true]);
					} else {
						owl.trigger("to.owl.carousel", [thisIndex, 400, true]);
					};
					if ($(settings["inner-menu"]).css('opacity') == "1" && $(settings["inner-menu"]).css('visibility') == "hidden") $(settings["inner-menu"]).css('opacity', "0");
					$(settings["inner-menu"]).stop(true, true).css("visibility", "visible");
					$(settings["inner-menu"]).animate({
						opacity: 1.0
					}, settings["ShowMenuFadeSpeed"], function() {});
				}
				objMenu.on('mouseleave', function() {
					methods.closeMenu();
				});
				$(document).on('touchend', function(event) {
					if ($(event.target).closest(settings["wrap-menu"]).length) return;
					methods.closeMenu();
				});
			},
			closeMenu: function(options) {
				clearTimeout(timerLi_open);
				$(settings["wrap-top-menu"] + ' li.li-hover').removeClass('li-hover');
				$(settings["inner-menu"]).animate({
					opacity: 0
				}, settings["ShowMenuFadeSpeed"], function() {
					$(settings["inner-menu"]).css({
						"visibility": "hidden"
					})
				});
				$(settings["wrap-menu"]).off('mouseleave', 'touchend');
			},
			MobileMenuCreate: function(options) {
				if ($('.mm-page').length) {
					return
				};
				$(settings["wrap-top-menu"] + " > ul > li").each(function() {
					var thisIndex = $(this).children('a').data('index');
					if (thisIndex == "0" || thisIndex) {
						var li_menu_1 = $(settings["inner-slide-menu"] + ' .item').eq(thisIndex).find(settings["inner-ul-1"]).clone(true);
						var li_menu_2 = $(settings["inner-slide-menu"] + ' .item').eq(thisIndex).find(settings["inner-ul-2"]).clone(true);
						if (li_menu_1.length || li_menu_2.length) {
							$(this).append("<div class='main-menu-lv-2 visible-xs'></div>");
							var liContent = $(this).find('.main-menu-lv-2');
							li_menu_1.prependTo(liContent);
							li_menu_2.prependTo(liContent);
						};
					};
				});
				$(settings["wrap-top-menu"] + " > ul").clone(true).prependTo(settings["menu-mobile"]);
				$(function() {
					$(settings["menu-mobile"]).mmenu({
						slidingSubmenus: true,
						position: 'left',
						zposition: 'next',
						moveBackground: true
					});
				});
			},
		};
		return methods.init();
	}
})(window, document, jQuery);
////////////NABOR/////////////
(function(window, document, $, undefined) {
	window.msDetailNabor = function(arParams) {
		this.SITE_ID = "";
		this.jsId = "";
		this.currencies = "";
		this.parentContId = "";
		this.ajaxPath = "";
		this.currency = "";
		this.mainElementPrice = "";
		this.mainElementOldPrice = "";
		this.mainElementDiffPrice = "";
		this.mainElementBasketQuantity = "";
		this.lid = "";
		this.iblockId = "";
		this.basketUrl = "";
		this.setIds = "";
		this.offersCartProps = "";
		this.itemsRatio = "";
		this.toggle = "";
		this.this_ = this;
		if ('object' === typeof arParams) {
			this.SITE_ID = arParams.SITE_ID;
			this.jsId = arParams.jsId;
			this.parentContId = arParams.parentContId;
			this.ajaxPath = arParams.ajaxPath;
			this.currency = arParams.currency;
			this.currencies = arParams.currencies;
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
			this.NaborAddBasket = this.parentContId + ' .nabor-basket-botton';
			this.check = this.parentContId + ' .check';
			this.Scroll = this.parentContId + ' #nabor-scroll';
		}
		this.init(this);
	};
	window.msDetailNabor.prototype.init = function(_this) {
		$(document).on("click", _this.check, _this, _this.clickCheckNabor);
		$(document).on("click", _this.toggle, _this, _this.clickToggle);
		$(document).on("click", _this.NaborAddBasket, _this, _this.clickNaborAddBasket);
	};
	window.msDetailNabor.prototype.clickToggle = function(e) {
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};
	window.msDetailNabor.prototype.clickCheckNabor = function(e) {
		_this = e.data;
		var id = $(this).closest('.nabor-item').data('id');
		if ($(this).closest('.nabor-item').hasClass('ibuy')) {
			$(this).html('');
			$(this).closest('.nabor-item').removeClass('ibuy');
			for (i = 0, l = _this.setIds.length; i < l; i++) {
				if (_this.setIds[i] == id) _this.setIds.splice(i, 1);
			}
		} else {
			$(this).html('<div class="checking"></div>');
			$(this).closest('.nabor-item').addClass('ibuy');
			_this.setIds.push(id);
		}
		var ElementSum = _this.mainElementPrice * _this.mainElementBasketQuantity;
		var ElementOldSum = _this.mainElementOldPrice * _this.mainElementBasketQuantity;
		var ItemsSum = 0;
		var ItemsOldSum = 0;
		$(_this.parentContId).find('.ibuy').each(function(index, value) {
			ItemsSum = ItemsSum + ($(this).data('price') * $(this).data('quantity'));
		});
		var AllSum = ElementSum + ItemsSum;
		var AllOldSum = ElementOldSum + ItemsOldSum;
		$(_this.parentContId).find('#nabor-basket-price span').html(AllSum);
	};
	window.msDetailNabor.prototype.clickNaborAddBasket = function(e) {
		e.preventDefault();
		_this = e.data;
		BX.ajax.post(_this.ajaxPath, {
			sessid: BX.bitrix_sessid(),
			action: 'catalogSetAdd2Basket',
			set_ids: _this.setIds,
			lid: _this.lid,
			iblockId: _this.iblockId,
			setOffersCartProps: _this.offersCartProps,
			itemsRatio: _this.itemsRatio
		}, BX.proxy(function(result) {
			BX.closeWait();
			$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
				scrollTop: 0
			}, 1000, BX.onCustomEvent('OnBasketChange'));
		}, this));
	};
})(window, document, jQuery);
///////////GIFT PRODUCT//////////////
(function(window, document, $, undefined) {
	window.msGiftProduct = function(arParams) {
		this.SITE_ID = "";
		this.Fuser = "";
		this.SiteDir = "";
		this.COLOR_UL = "";
		this.COLOR_UL_HOR = "";
		this.ModifSizeCol = "";
		this.js_slider_pic_small = "";
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
		if ('object' === typeof arParams) {
			this.SITE_ID = arParams.SITE_ID;
			this.Fuser = arParams.Fuser;
			this.SiteDir = arParams.SiteDir;
			this.COLOR_UL = arParams.COLOR_UL;
			this.COLOR_UL_HOR = arParams.COLOR_UL_HOR;
			this.js_slider_pic_small = arParams.js_slider_pic_small;
			this.PRODUCT_ID = arParams.PRODUCT_ID;
			this.offerID = arParams.OFFER_ID;
			this.DETAIL_PAGE_URL = arParams.DETAIL_PAGE_URL;
			this.container = arParams.gift + " " + arParams.prop + " " + arParams.child_prop;
			this.propimg = arParams.prop_img;
			this.ul = arParams.prop;
			this.li = arParams.child_prop;
			this.classLiActive = arParams.class_li_active;
			this.classLiDesabled = arParams.class_li_disable;
			this.classLiAvailable = arParams.class_li_available;
			this.imgContainer = arParams.image_container;
			this.priceContainer = arParams.main + " " + arParams.price_container;
			this.availableContainer = arParams.main + " " + arParams.available_container;
			this.quantityInput = arParams.main + " " + arParams.quantity_input;
			this.arImage = arParams.image;
			this.TemplatePath = arParams.TemplatePath;
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
	window.msGiftProduct.prototype.init = function(_this) {
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
	window.msGiftProduct.prototype.destroy = function() {
		$(document).off("click", this.container, this.clickProp);
		$(document).off("mouseenter", this.propimg, this.clickProp);
		$(document).off("click", this.add_url, this.clickAddBasket);
		$(document).off("click", this.add_wish, this.clickAddWish);
		$(document).off("click", this.add_subscribe, this.clickAddSubscribe);
		$(document).off("click", this.submit_subscribe, this.clickAddSubscribeEmail);
		$(document).off("click", this.toggle, this.clickToggle);
		$(document).off("mouseenter", this.add_url, this.checkStringProps);
		$(document).off("mouseenter", this.add_wish, this.checkStringProps);
		$(document).off("mouseenter", this.add_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.submit_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.contSelectProps, this.checkStringProps);
	};
	window.msGiftProduct.prototype.clickToggle = function(e) {
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};
	window.msGiftProduct.prototype.checkStringProps = function(e) {
		_this = e.data;
		strTitle = "";
		cont_modal = $(this);
		if (_this.offerID <= 0) {
			bool = true;
			$(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					if (bool) strTitle += $(this).attr("title");
					else strTitle += ", " + $(this).attr("title");
					bool = false;
				}
			})
			if (!bool) {
				cont_modal.msTooltip({
					"class": "class_check_props",
					"message": BX.message("MS_JS_CATALOG_SELECT_PROP") + " " + strTitle,
					"is_hover": true,
					"timeOut": true
				});
				return false;
			}
		}
		return true;
	};
	window.msGiftProduct.prototype.counter = function(_this) {
		if (_this.SITE_ID == "" || _this.PRODUCT_ID == "") return false;
		path = '/bitrix/components/bitrix/catalog.element/ajax.php';
		params = {
			AJAX: 'Y',
			SITE_ID: _this.SITE_ID,
			PRODUCT_ID: _this.PRODUCT_ID,
			PARENT_ID: 0
		};
		BX.ajax.post(path, params, function(data) {});
	};
	window.msGiftProduct.prototype.clickAddBasket = function(e) {
		e.preventDefault();
		_this = e.data;

		arOffer = $('.js_detail_prop_block ul').eq(0).find('.li-active').eq(0).attr("data-offer").split(",");
		countUl = $('.js_detail_prop_block ul').length;
		countLi = $('.js_detail_prop_block ul').find('.li-active').length;
		if (countUl == countLi)
		{

			$.ajax({
				type: 'POST',
				url: _this.SiteDir + 'include/ajax/user_basket.php',
				data: {'FUSER_ID':_this.Fuser,'SITE_ID':_this.SITE_ID},
				success: function(data){

					var offerID = 0;
					$('.js_detail_prop_block ul').each(function() {
						$(this).find('.li-active').each(function() {
							arAttrOffer = $(this).attr("data-offer").split(",");
							$.each(arOffer, function(i, v) {
								if ($.inArray(v, arAttrOffer) == -1) delete arOffer[i];
								else offerID = v;
							})
						});
					});

					var basket = JSON.parse(data);
					var addMain = true;
					for (var key in basket)
					{
						if(offerID == key)
						{
							addMain = false;
						}
					}
					if(addMain)
					{
						url = "?action=BUY&id="+offerID+"&ajax_basket=Y&quantity=1";
						BX.ajax.loadJSON(url, "");
					}
				},
				error:  function(xhr, str){
					alert(xhr.responseCode);
				}
			});
		}




		if (!_this.checkProps($(_this.add_url))) return false;
		_this.ProductId = $(this).closest('.one-item').data('id');
		if (_this.offerID[_this.ProductId] == 0) _this.offerID[_this.ProductId] = _this.ProductId;
		url = _this.basket_url[_this.offerID[_this.ProductId]];
		url += "&quantity=1";
		BX.ajax.loadJSON(url, "", _this.successBasket);
	};
	window.msGiftProduct.prototype.clickAddWish = function(e) {
		e.preventDefault();
		_this = e.data;
		_this.ProductId = $(this).closest('.one-item').data('id');
		if (!_this.checkProps($(_this.add_wish))) return false;
		url = _this.wish_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, "", _this.successWish);
	};
	window.msGiftProduct.prototype.clickAddSubscribe = function(e) {
		e.preventDefault();
		_this.ProductId = $(this).closest('.one-item').data('id');
		_this = e.data;
		if (!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, "", _this.successSubscribe);
	};
	window.msGiftProduct.prototype.clickAddSubscribeEmail = function(e) {
		e.preventDefault();
		_this.ProductId = $(this).closest('.one-item').data('id');
		_this = e.data;
		ser = $('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form').serialize();
		email = $('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form input[type=text]').val();
		if (email == "") return false;
		if (!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, ser + "&ajax_email=Y", _this.successSubscribeEmail);
	};
	window.msGiftProduct.prototype.mouseLeaveBasket = function(e) {
		$(this).fadeOut(400, function() {
			$(this).remove();
		});
	};
	window.msGiftProduct.prototype.successBasket = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id=' + _this.ProductId + ']').find('.btn_add_basket_gift').msTooltip({
				"class": "class_basket",
				"message": BX.message("MS_JS_CATALOG_ADD_BASKET"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddBasket();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftProduct.prototype.successWish = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id=' + _this.ProductId + ']').find('.btn_add_wish_gift').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_WISH"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftProduct.prototype.successSubscribe = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_product_form .back_call_submit').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftProduct.prototype.successSubscribeEmail = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form input[type=submit]').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftProduct.prototype.afterAddBasket = function() {
		_this = this;
		$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
			scrollTop: 0
		}, 1000, function() {
			BX.onCustomEvent('OnBasketChange');
		});
	};
	window.msGiftProduct.prototype.afterAddBasketMobile = function() {
		_this = this;
		BX.onCustomEvent('OnBasketChange');
	};
	window.msGiftProduct.prototype.afterAddWish = function() {
		_this = this;
	};
	window.msGiftProduct.prototype.afterSuccesBasket = function(data) {
		_this.boolLoadBasket = true;
		if (data == "") return false;
		$(_this.contBasket).children().remove();
		$(_this.contBasket).unbind("mouseleave");
		var h_basket = $(_this.contBasket).innerHeight() + "px";
		$(".window_basket").css("top", h_basket);
		$(_this.contBasket + " .window_basket").hide();
		if (_this.boolScrollBasket) {
			$(_this.contBasket + " .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
	};
	window.msGiftProduct.prototype.scrollTopEnd = function() {
		_this.boolScrollBasket = true;
		if (_this.boolLoadBasket) {
			$(_this.contBasket + " .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
	};
	window.msGiftProduct.prototype.scrollSlideEnd = function() {
		time = setTimeout(function() {
			$(_this.contBasket + " .window_basket").fadeOut(500, function() {
				$(this).remove()
			});
		}, 5000);
		$(document).on("mouseenter", _this.contBasket + " .window_basket", function() {
			clearInterval(time);
			time = setTimeout(function() {
				$(_this.contBasket + " .window_basket .basket-item").slideDown(500);
			}, 2000);
		});
		$(_this.contBasket + " .window_basket").on("mouseleave", _this.mouseLeaveBasket);
	};
	window.msGiftProduct.prototype.checkProps = function(cont_modal) {
		_this = this;
		if (_this.offerID[_this.ProductId] <= 0) {
			bool = true;
			$(_this.currentLi).closest('.one-item').find(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					bool = false;
				}
			})
			if (!bool) {
				return false;
			}
		}
		return true;
	};
	window.msGiftProduct.prototype.clickProp = function(e) {
		_this = e.data;
		if ($(this).is(_this.classLiDesabled)) return false;
		xmlID = $(this).attr("data-xml");
		_this.currentLi = $(this);
		_this.parent = $(this).parents(_this.ul).eq(0);
		_this.ProductId = $(this).closest('.one-item').data('id');
		_this.currentUl = $(_this.ul).index(_this.parent);
		_this.calculate();
		_this.calculateAvailable();
		_this.calculateID();
		_this.calculateAvailableBlock();
		_this.calculatePrice();
		return false;
	};
	window.msGiftProduct.prototype.calculate = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		$(_this.currentLi).closest('ul').find('.li-active').removeClass("li-active");
		$(_this.currentLi).not('.li-disable').not('.li-active').addClass("li-active");
		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).each(function() {
					$(this).removeClass("li-disable");
					arOfferAttr = $(this).attr("data-offer").split(",");
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-disable");
						$(this).removeClass("li-active");
						$(this).removeClass("li-available");
					}
				})
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msGiftProduct.prototype.calculateAvailable = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		offerAvailable = _this.offerAvailable;
		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).not(".li-disable").each(function() {
					$(this).removeClass("li-available");
					arOfferAttr = $(this).attr("data-offer").split(",");
					arOfferAttr = arOfferAttr.filter(function(n) {
						if (typeof offerAvailable[n] == "undefined") return true;
						else return false;
					});
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-available");
					}
				});
				AllCnt = $(this).find(_this.li).length;
				OtherCnt = $(this).find(_this.li).not(".li-active").length;
				if (AllCnt - OtherCnt == 0) {
					$(this).find(_this.li).not(".li-disable").first().trigger('click');
					return false;
				}
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msGiftProduct.prototype.calculateID = function() {
		_this = this;
		arOffer = $(_this.currentLi).closest('.one-item').find(_this.ul).eq(0).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
		countUl = $(_this.ul).length;
		countLi = $(_this.ul).find(_this.classLiActive).length;
		if (countUl != countLi) {
			_this.offerID[_this.ProductId] = 0;
			return false;
		}
		$(_this.currentLi).closest('.one-item').find(_this.ul).each(function() {
			_this.offerID[_this.ProductId] = 0;
			$(this).find(_this.classLiActive).each(function() {
				arAttrOffer = $(this).attr("data-offer").split(",");
				$.each(arOffer, function(i, v) {
					if ($.inArray(v, arAttrOffer) == -1) delete arOffer[i];
					else _this.offerID[_this.ProductId] = v;
				})
			});
		})
	};
	window.msGiftProduct.prototype.calculateAvailableBlock = function() {
		_this = this;
		if (_this.offerID[_this.ProductId] && typeof _this.offerID[_this.ProductId] != "undefined") {
			offerAvailable = _this.offerAvailable;
			if (typeof offerAvailable[_this.offerID[_this.ProductId]] != "undefined") {
				$('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_cont').show();
				$('.one-item[data-id=' + _this.ProductId + ']').find('.detail_block_price_cont').hide();
			} else {
				$('.one-item[data-id=' + _this.ProductId + ']').find('.subscribe_cont').hide();
				$('.one-item[data-id=' + _this.ProductId + ']').find('.detail_block_price_cont').show();
			}
		}
	}
	window.msGiftProduct.prototype.calculatePrice = function() {
		if (this.offerID[this.ProductId] > 0) {
			$(_this.currentLi).closest('.one-item').find(this.discountPrice).text(this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"]);
			if (this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"] != this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]) {
				$(_this.currentLi).closest('.one-item').find(this.oldPrice).text(this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]);
			} else $(_this.currentLi).closest('.one-item').find(this.oldPrice).text('');
		}
	};
})(window, document, jQuery);
///////////////GIFT MAIN///////////////////
(function(window, document, $, undefined) {
	window.msGiftMainProduct = function(arParams) {
		this.SITE_ID = "";
		this.COLOR_UL = "";
		this.COLOR_UL_HOR = "";
		this.ModifSizeCol = "";
		this.js_slider_pic_small = "";
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
		if ('object' === typeof arParams) {
			this.SITE_ID = arParams.SITE_ID;
			this.COLOR_UL = arParams.COLOR_UL;
			this.COLOR_UL_HOR = arParams.COLOR_UL_HOR;
			this.js_slider_pic_small = arParams.js_slider_pic_small;
			this.PRODUCT_ID = arParams.PRODUCT_ID;
			this.offerID = arParams.OFFER_ID;
			this.DETAIL_PAGE_URL = arParams.DETAIL_PAGE_URL;
			this.container = arParams.giftmain + " " + arParams.prop + " " + arParams.child_prop;
			this.propimg = arParams.prop_img;
			this.ul = arParams.prop;
			this.li = arParams.child_prop;
			this.classLiActive = arParams.class_li_active;
			this.classLiDesabled = arParams.class_li_disable;
			this.classLiAvailable = arParams.class_li_available;
			this.imgContainer = arParams.image_container;
			this.priceContainer = arParams.main + " " + arParams.price_container;
			this.availableContainer = arParams.main + " " + arParams.available_container;
			this.quantityInput = arParams.main + " " + arParams.quantity_input;
			this.arImage = arParams.image;
			this.TemplatePath = arParams.TemplatePath;
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
	window.msGiftMainProduct.prototype.init = function(_this) {
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
	window.msGiftMainProduct.prototype.destroy = function() {
		$(document).off("click", this.container, this.clickProp);
		$(document).off("mouseenter", this.propimg, this.clickProp);
		$(document).off("click", this.add_url, this.clickAddBasket);
		$(document).off("click", this.add_wish, this.clickAddWish);
		$(document).off("click", this.add_subscribe, this.clickAddSubscribe);
		$(document).off("click", this.submit_subscribe, this.clickAddSubscribeEmail);
		$(document).off("click", this.toggle, this.clickToggle);
		$(document).off("mouseenter", this.add_url, this.checkStringProps);
		$(document).off("mouseenter", this.add_wish, this.checkStringProps);
		$(document).off("mouseenter", this.add_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.submit_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.contSelectProps, this.checkStringProps);
	};
	window.msGiftMainProduct.prototype.clickToggle = function(e) {
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};
	window.msGiftMainProduct.prototype.checkStringProps = function(e) {
		_this = e.data;
		strTitle = "";
		cont_modal = $(this);
		if (_this.offerID <= 0) {
			bool = true;
			$(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					if (bool) strTitle += $(this).attr("title");
					else strTitle += ", " + $(this).attr("title");
					bool = false;
				}
			})
			if (!bool) {
				cont_modal.msTooltip({
					"class": "class_check_props",
					"message": BX.message("MS_JS_CATALOG_SELECT_PROP") + " " + strTitle,
					"is_hover": true,
					"timeOut": true
				});
				return false;
			}
		}
		return true;
	};
	window.msGiftMainProduct.prototype.counter = function(_this) {
		if (_this.SITE_ID == "" || _this.PRODUCT_ID == "") return false;
		path = '/bitrix/components/bitrix/catalog.element/ajax.php';
		params = {
			AJAX: 'Y',
			SITE_ID: _this.SITE_ID,
			PRODUCT_ID: _this.PRODUCT_ID,
			PARENT_ID: 0
		};
		BX.ajax.post(path, params, function(data) {});
	};
	window.msGiftMainProduct.prototype.clickAddBasket = function(e) {
		e.preventDefault();
		_this = e.data;
		if (!_this.checkProps($(_this.add_url))) return false;
		_this.ProductId = $(this).closest('.item').data('id');
		if (_this.offerID[_this.ProductId] == 0) _this.offerID[_this.ProductId] = _this.ProductId;
		url = _this.basket_url[_this.offerID[_this.ProductId]];
		url += "&quantity=1";
		BX.ajax.loadJSON(url, "", _this.successBasket);
	};
	window.msGiftMainProduct.prototype.clickAddWish = function(e) {
		e.preventDefault();
		_this = e.data;
		_this.ProductId = $(this).closest('.item').data('id');
		if (!_this.checkProps($(_this.add_wish))) return false;
		url = _this.wish_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, "", _this.successWish);
	};
	window.msGiftMainProduct.prototype.clickAddSubscribe = function(e) {
		e.preventDefault();
		_this.ProductId = $(this).closest('.item').data('id');
		_this = e.data;
		if (!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, "", _this.successSubscribe);
	};
	window.msGiftMainProduct.prototype.clickAddSubscribeEmail = function(e) {
		e.preventDefault();
		_this.ProductId = $(this).closest('.item').data('id');
		_this = e.data;
		ser = $('.item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form').serialize();
		email = $('.item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form input[type=text]').val();
		if (email == "") return false;
		if (!_this.checkProps($(_this.add_subscribe))) return false;
		url = _this.subscribe_url[_this.offerID[_this.ProductId]];
		BX.ajax.loadJSON(url, ser + "&ajax_email=Y", _this.successSubscribeEmail);
	};
	window.msGiftMainProduct.prototype.mouseLeaveBasket = function(e) {
		$(this).fadeOut(400, function() {
			$(this).remove();
		});
	};
	window.msGiftMainProduct.prototype.successBasket = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.item[data-id=' + _this.ProductId + ']').find('.btn_add_basket_gift').msTooltip({
				"class": "class_basket",
				"message": BX.message("MS_JS_CATALOG_ADD_BASKET"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile)
			{
				_this.afterAddWish();
			}
			else
			{
				_this.afterAddBasket();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftMainProduct.prototype.successWish = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.item[data-id=' + _this.ProductId + ']').find('.btn_add_wish_gift').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_WISH"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftMainProduct.prototype.successSubscribe = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.item[data-id=' + _this.ProductId + ']').find('.subscribe_product_form .back_call_submit').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftMainProduct.prototype.successSubscribeEmail = function(data) {
		if (data.STATUS == "OK") {
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			$('.item[data-id=' + _this.ProductId + ']').find('.subscribe_new_form input[type=submit]').msTooltip({
				"class": "class_wish",
				"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
				"is_hover": false,
				"timeOut": false
			});
			if (_this.isMobile) {
				_this.afterAddWish();
			} else {
				_this.afterAddWish();
			}
		} else alert(data.MESSAGE);
	};
	window.msGiftMainProduct.prototype.afterAddBasket = function() {
		_this = this;

		$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
			scrollTop: 0
		}, 1000, function() {
			BX.onCustomEvent('OnBasketChange');
		});
	};
	window.msGiftMainProduct.prototype.afterAddBasketMobile = function() {
		_this = this;
		BX.onCustomEvent('OnBasketChange');
	};
	window.msGiftMainProduct.prototype.afterAddWish = function() {
		_this = this;
	};
	window.msGiftMainProduct.prototype.afterSuccesBasket = function(data) {
		_this.boolLoadBasket = true;
		if (data == "") return false;
		$(_this.contBasket).children().remove();
		$(_this.contBasket).unbind("mouseleave");
		var h_basket = $(_this.contBasket).innerHeight() + "px";
		$(".window_basket").css("top", h_basket);
		$(_this.contBasket + " .window_basket").hide();
		if (_this.boolScrollBasket) {
			$(_this.contBasket + " .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
	};
	window.msGiftMainProduct.prototype.scrollTopEnd = function() {
		_this.boolScrollBasket = true;
		if (_this.boolLoadBasket) {
			$(_this.contBasket + " .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
	};
	window.msGiftMainProduct.prototype.scrollSlideEnd = function() {
		time = setTimeout(function() {
			$(_this.contBasket + " .window_basket").fadeOut(500, function() {
				$(this).remove()
			});
		}, 5000);
		$(document).on("mouseenter", _this.contBasket + " .window_basket", function() {
			clearInterval(time);
			time = setTimeout(function() {
				$(_this.contBasket + " .window_basket .basket-item").slideDown(500);
			}, 2000);
		});
		$(_this.contBasket + " .window_basket").on("mouseleave", _this.mouseLeaveBasket);
	};
	window.msGiftMainProduct.prototype.checkProps = function(cont_modal) {
		_this = this;
		if (_this.offerID[_this.ProductId] <= 0) {
			bool = true;
			$(_this.currentLi).closest('.item').find(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					bool = false;
				}
			})
			if (!bool) {
				return false;
			}
		}
		return true;
	};
	window.msGiftMainProduct.prototype.clickProp = function(e) {
		_this = e.data;
		if ($(this).is(_this.classLiDesabled)) return false;
		xmlID = $(this).attr("data-xml");
		_this.currentLi = $(this);
		_this.parent = $(this).parents(_this.ul).eq(0);
		_this.ProductId = $(this).closest('.item').data('id');
		_this.currentUl = $(_this.ul).index(_this.parent);
		_this.calculate();
		_this.calculateAvailable();
		_this.calculateID();
		_this.calculateAvailableBlock();
		_this.calculatePrice();
		return false;
	};
	window.msGiftMainProduct.prototype.calculate = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		$(_this.currentLi).closest('ul').find('.li-active').removeClass("li-active");
		$(_this.currentLi).not('.li-disable').not('.li-active').addClass("li-active");
		$(_this.currentLi).closest('.item').find(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).each(function() {
					$(this).removeClass("li-disable");
					arOfferAttr = $(this).attr("data-offer").split(",");
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-disable");
						$(this).removeClass("li-active");
						$(this).removeClass("li-available");
					}
				})
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msGiftMainProduct.prototype.calculateAvailable = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		offerAvailable = _this.offerAvailable;
		$(_this.currentLi).closest('.item').find(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).not(".li-disable").each(function() {
					$(this).removeClass("li-available");
					arOfferAttr = $(this).attr("data-offer").split(",");
					arOfferAttr = arOfferAttr.filter(function(n) {
						if (typeof offerAvailable[n] == "undefined") return true;
						else return false;
					});
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-available");
					}
				});
				AllCnt = $(this).find(_this.li).length;
				OtherCnt = $(this).find(_this.li).not(".li-active").length;
				if (AllCnt - OtherCnt == 0) {
					$(this).find(_this.li).not(".li-disable").first().trigger('click');
					return false;
				}
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msGiftMainProduct.prototype.calculateID = function() {
		_this = this;
		arOffer = $(_this.currentLi).closest('.item').find(_this.ul).eq(0).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
		countUl = $(_this.ul).length;
		countLi = $(_this.ul).find(_this.classLiActive).length;
		if (countUl != countLi) {
			_this.offerID[_this.ProductId] = 0;
			return false;
		}
		$(_this.currentLi).closest('.item').find(_this.ul).each(function() {
			_this.offerID[_this.ProductId] = 0;
			$(this).find(_this.classLiActive).each(function() {
				arAttrOffer = $(this).attr("data-offer").split(",");
				$.each(arOffer, function(i, v) {
					if ($.inArray(v, arAttrOffer) == -1) delete arOffer[i];
					else _this.offerID[_this.ProductId] = v;
				})
			});
		})
	};
	window.msGiftMainProduct.prototype.calculateAvailableBlock = function() {
		_this = this;
		if (_this.offerID[_this.ProductId] && typeof _this.offerID[_this.ProductId] != "undefined") {
			offerAvailable = _this.offerAvailable;
			if (typeof offerAvailable[_this.offerID[_this.ProductId]] != "undefined") {
				$('.item[data-id=' + _this.ProductId + ']').find('.subscribe_cont').show();
				$('.item[data-id=' + _this.ProductId + ']').find('.detail_block_price_cont').hide();
			} else {
				$('.item[data-id=' + _this.ProductId + ']').find('.subscribe_cont').hide();
				$('.item[data-id=' + _this.ProductId + ']').find('.detail_block_price_cont').show();
			}
		}
	}
	window.msGiftMainProduct.prototype.calculatePrice = function() {
		if (this.offerID[this.ProductId] > 0) {
			$(_this.currentLi).closest('.item').find(this.discountPrice).text(this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"]);
			if (this.prices[this.offerID[this.ProductId]]["DISCOUNT_PRICE"] != this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]) {
				$(_this.currentLi).closest('.item').find(this.oldPrice).text(this.prices[this.offerID[this.ProductId]]["OLD_PRICE"]);
			} else $(_this.currentLi).closest('.item').find(this.oldPrice).text('');
		}
	};
})(window, document, jQuery);

function resizeOwl() {
	var MaxHeight = 0;
	var MaxPadding = 0;
	$('.giftmain  .item_open .buy_now_bottom').each(function(index, value) {
		var Height = $(this).height();
		if (index == 0) MaxHeight = Height;
		if (Height > MaxHeight) MaxHeight = Height;
	});
	$('.giftmain  .item .buy_now_bottom-close').each(function(index, value) {
		if (MaxHeight - $(this).height() > MaxPadding) MaxPadding = MaxHeight - $(this).height();
	});
	MaxPadding += 5;
	$('.giftmain .owl-stage-outer').css('padding-bottom', MaxPadding);
	$('.giftmain .owl-stage-outer').css('margin-bottom', -MaxPadding);
}
$(document).ready(function()
{
	$('.open-modal-window').on("click", function()
	{
		var href_ = $(this).attr('href');
		var class_ = $(this).attr('data-class');
		modalLoad(href_, class_);
		return false;
	});
	if ($('html').width() >= 751)
	{
		h_footer_menu();
	};
	$('.footer_menu li').hover(function()
	{
		$(this).addClass('li-hover');
	}, function() {
		$(this).removeClass('li-hover');
	});
	$('input[type="radio"]').each(function()
	{
		var cheked_ = $(this).prop('checked');
		if (cheked_) {
			change_label_radio(this);
		}
	});
	$('input[type="checkbox"]').each(function()
	{
		change_label_checkbox(this);
	});
	if ($('#block_menu_filter').length)
	{
		/*$("#block_menu_filter .scrollbarY").each(function()
		{
			var this_ = $(this);
			block_viewport_h(this_);
		});*/
		$("#block_menu_filter .scrollbarY:visible").each(function()
		{
			$(this).find('.overview').niceScroll({cursoropacitymin: 1,cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
			/*
			$(this).tinyscrollbar({
				thumbSize: 16
			});*/
		});
		if ($('html').width() < 751)
		{
			close_filter()
		}
	}
	if ($('html').width() >= 751)
	{
		$(document).on('mouseenter', '#block-gift .one-item', function()
		{
			var this_ = $(this);
			section_wrap_item_show(this_);
		});
		$(document).on('mouseleave', '#block-gift .one-item', function()
		{
			var this_ = $(this);
			section_wrap_item_hide(this_);
		});
	}
	if ($('html').width() >= 751) {
		$(document).on('mouseenter', '#block-giftbasket .one-item', function() {
			var this_ = $(this);
			section_wrap_item_show(this_);
		});
		$(document).on('mouseleave', '#block-giftbasket .one-item', function() {
			var this_ = $(this);
			section_wrap_item_hide(this_);
		});
	}
	if ($('html').width() >= 751) {
		$(document).on('mouseenter', '#giftmain .item', function() {
			var this_ = $(this);
			buy_now_wrap_item_show(this_);
		});
		$(document).on('mouseleave', '#giftmain .item', function() {
			var this_ = $(this);
			buy_now_wrap_item_hide(this_);
		});
	}
	if ($('html').width() >= 751) {
		$(document).on('mouseleave', '.one-item', function() {
			var this_ = $(this);
			section_wrap_item_hide(this_);
		});
	}
	if ($('#section_list').length) {
		/*if ($('#section_list .icon_property_wrap').length) {
			icon_position('#section_list .icon_property_wrap');
		}*/
		$(function() {
			if (!$.browser.safari) $('.wrap_select_sort select').ikSelect();
		});
		$(function() {
			if (!$.browser.safari) $('.wrap_select_number select').ikSelect();
		});
	}

	if ($('.icon_property_wrap').length)
	{
		icon_position('.icon_property_wrap');
	}


	var MaxHeight = 0;
	$('#block-gift  .item').each(function(index, value) {
		var BottomHeight = $(this).find('.block_size_color').height();
		if (BottomHeight > MaxHeight) MaxHeight = BottomHeight;
	});
	MaxHeight += 10;
	$('#block-gift .item').css('padding-bottom', MaxHeight + 'px');
	if ($('.inner_page').length || $(".block_buy_now").length) {
		$(document).on('mouseenter', '.block-picture > li > a', function() {
			$(this).children('.picture-descript').stop(true, false).animate({
				'bottom': "0"
			}, 400);
		});
		$(document).on('mouseleave', '.block-picture > li > a', function() {
			$(this).children('.picture-descript').animate({
				'bottom': "-100%"
			}, 400);
		});
		$(document).on('click', '.detail_page_wrap .js_detail_prop ul > li', function() {
			$(this).not('.li-disable').not('.li-active').addClass("li-active");
			$(this).parent('ul').children().not(this).removeClass("li-active");
		});
		$(document).on('click', '#basket_form .js_detail_prop ul > li', function() {
			$(this).not('.li-disable').not('.li-active').addClass("li-active");
			$(this).parent('ul').children().not(this).removeClass("li-active");
		});
		$(document).on('click', '.detail_page_wrap .button_js', function() {
			$(this).next(".block_js").stop(true, false).slideToggle("slow");
			$(this).parent('.description_block').toggleClass('block_open');
		});
		if ($('.wrap_pic_js').length) {
			zoom_detail_img();
		}
		if ($('html').width() < 751 && $(".js-title").length) {
			$(".js-title").clone(true).prependTo('.detail_page_wrap');
		}
		if ($('.phone').length) {
			$(document).on('focus', 'input.phone', function() {
				$.mask.definitions['~'] = '[+-9() ]';
				$(this).mask("~~~~?~~~~~~~~~~~~~~~~~", {
					placeholder: " "
				});
			});
		}
	}
	if ($(".brand_list").length) {
		if ($('html').width() >= 751) {
			h_brand_cart_wrap();
		}
	}
});

function giftmain_wrap_item_show(this_)
{
	var this_active = this_.addClass('hover');
	var buy_now_top_first = this_.children('.item-top-part:first');
	$('.giftmain .owl-item').removeClass('active-first');
	$('.giftmain .owl-item.active:first').addClass('active-first');
	var width_buy_top = buy_now_top_first.width();
	var height_buy_top = buy_now_top_first.height();
	this_.find('.item-top-part:last').width(width_buy_top).height(height_buy_top);
	var height_buy_small = buy_now_top_first.outerHeight();
	this_.find('.buy_now_top_small_img').css('min-height', height_buy_small);
	if (this_.find('.swiper-container').length) {
		do_swiper(this_);
	}
	section_wrap_item_hide_all();
};

function giftmain_wrap_item_hide(this_) {
	this_.removeClass('active-first');
	this_.removeClass('hover');
};
$(window).bind("resize", function() {
	if ($('.icon_property_wrap').length) {
		icon_position('.icon_property_wrap');
	}
});

function buy_now_wrap_item_show(this_) {
	var this_active = this_.parent('.owl-item').addClass('hover');
	var buy_now_top_first = this_.children('.buy_now_top:first');
	var this_index = this_.parents(".owl-stage").children(".owl-item.active").index(this_active);
	if (!this_index) {
		this_active.addClass('active-first');
	}
	var width_buy_top = buy_now_top_first.width();
	var height_buy_top = buy_now_top_first.height();
	$('.buy_now_top:last', this_).width(width_buy_top).height(height_buy_top);
	var height_buy_small = buy_now_top_first.outerHeight();
	$('.buy_now_top_small_img', this_).css('min-height', height_buy_small);
	if ($('.swiper-container', this_).length) {
		do_swiper(this_);
	}
	wrap_item_hide_all();
};

function LazyLoad() {
	if($(".b-lazy-wrapper").length)
	{
		if (navigator.userAgent.indexOf('Safari') != -1 && navigator.userAgent.indexOf('Chrome') == -1) {
			$(".b-lazy-wrapper").each(function() {
				var img = $('img', this);
				var src = img.attr('data-src');
				img.attr('src', src);
				if (img.parent().attr('class') == 'b-lazy-wrapper') img.unwrap();
			});
		}
		else {
			$(".b-lazy-wrapper").each(function() {
				var WrapperWidth = $(this).data('width');
				var WrapperHeight = $(this).data('height');
				if (WrapperWidth !== undefined && WrapperWidth !== false && WrapperHeight !== undefined && WrapperHeight !== false) {
					var ParentWidth = $(this).parent().width();
					if (ParentWidth < WrapperWidth) {
						var NewWrapperHeight = Math.round((WrapperHeight * ParentWidth) / WrapperWidth);
						$(this).height(NewWrapperHeight);
					}
				}
			});
			var bLazy = new Blazy({
				selector: '.b-lazy',
				loadInvisible: 'true',
				success: function(image) {
					var element = $(image);
					if (element.parent().attr('class') == 'b-lazy-wrapper') element.unwrap();
				}
			});
		}
	}
}

function buy_now_wrap_item_hide(this_) {
	this_.parent('.owl-item').removeClass('active-first');
	this_.parent('.owl-item').removeClass('hover');
};

function wrap_item_hide_all() {
	$(window).bind("resize", function() {
		$('#buy-now-slider .owl-item.hover').removeClass('hover');
		$('#buy-now-slider .owl-item.active-first').removeClass('active-first');
	});
};

function icon_position(element) {
	var top_const = 4;
	var right_const = 8;
	var step = 8;

	$(element).each(function()
	{
		if($(this).data('index') == 0)
		{
			step = 8;
		}
		var h_prop = $(this).outerHeight();
		var right_prop = right_prop + right_const;

		$(this).css({
			'right': h_prop + step,
		});

		step+=h_prop*0.75;
	});
};

function section_wrap_item_show(this_) {
	var this_active = this_.addClass('hover');
	if (this_.parent().hasClass('owl-item')) // if slider
	{
		this_.parent('.owl-item').addClass('hover'); // need because owl left
		// covered by second
		var this_index = this_.parents(".owl-stage").find(".owl-item.active .one-item").index(this_active);
	} else {
		var this_index = this_.closest('.row').find('.one-item').index(this_active);
	}
	var buy_now_top_first = this_.children('.item-top-part:first');
	if (!this_index) {
		this_active.addClass('active-first');
	}
	var width_buy_top = buy_now_top_first.width();
	var height_buy_top = buy_now_top_first.height();
	$('.item-top-part:last', this_).width(width_buy_top).height(height_buy_top);
	var height_buy_small = buy_now_top_first.outerHeight();
	$('.buy_now_top_small_img', this_).css('min-height', height_buy_small);
	if ($('.swiper-container', this_).length) {
		do_swiper(this_);
	}
	section_wrap_item_hide_all();
};

function section_wrap_item_hide(this_) {
	if (this_.parent().hasClass('owl-item')) // if slider
	{
		this_.parent().removeClass('hover');
	}
	this_.removeClass('active-first');
	this_.removeClass('hover');
};

function section_wrap_item_hide_all() {
	$(window).bind("resize", function() {
		$('.one-item.hover').removeClass('hover');
		$('.one-item.active-first').removeClass('active-first');
	});
};
var swip_slider = "";

function do_swiper(this_) {
	var id_slider = $('.swiper-container', this_).attr('id');
	if ($('.swiper-container', this_).closest('.owl-item').length) {
		id_slider = '.active #' + id_slider;
	} else {
		id_slider = '#' + id_slider;
	}

	swip_slider = new Swiper(id_slider, {
		mode: 'vertical',
		autoResize: true,
		slidesPerView: 1,
		calculateHeight: true,
		preventLinksPropagation: true,
		mousewheelControl: true,
		resizeReInit: true,
	});
	id_top = id_slider + "_top";
	id_bottom = id_slider + "_bottom";
	$(id_top).on('click', function() {
		swip_slider.swipePrev();
		//owl.trigger('next.owl');
	})
	$(id_bottom).on('click', function() {
		swip_slider.swipeNext();
		//owl.trigger('prev.owl');
	});
}
$(window).bind("resize", function() {
	if ($('html').width() >= 751) {
		h_footer_menu();
	} else {
		$('#footer .footer_menu > li > ul').height('auto');
	};
});

function h_footer_menu() {
	var h_footer_ul = 0;
	$('#footer .footer_menu > li > ul').each(function() {
		var this_h = $(this).height();
		if (this_h > h_footer_ul) {
			h_footer_ul = this_h;
		}
	});
	$('#footer .footer_menu > li > ul').height(h_footer_ul);
};

function toggle_alpha() {
	$("#alpha_eng").toggle();
	$("#alpha_rus").toggle();
	$("#toggle_alpha span").toggle();
};

function toggle_alpha_inner(this_, isMobile_) {
	var item_ = $(this_).children(".alpha_inner");
	$(item_).toggle();
	$(".main-top-center .alpha_inner:visible").not(item_).hide();
	$('.block_alpha').on('mouseleave', function(event) {
		var timerId_block = setTimeout(function() {
			$(".main-top-center .alpha_inner:visible").hide();
		}, 500);
		$(this).mouseenter(function() {
			clearTimeout(timerId_block);
		});
	});
	if (isMobile_) {
		$(document).on('scroll', function() {
			$(".main-top-center .alpha_inner:visible").hide();
		});
	}
};

function modalLoad(openUrl, class_) {
	$.ajax({
		url: openUrl,
		cache: false,
		success: function(html) {
			modal_windows_show(html, class_);
		}
	});
}

function modal_windows_show(content, class_)
{

	var block = "<div class='modal-window bootstrap_style " + class_ + "'><div class='modal-window-bg'>&nbsp;</div>" + "<div class='wrap-out'><div class='container'><div class='row'><div class='modal-block'>" + "<div class='modal-block-inner'><span class='close'></span><div class='modal-content'>" + content + "</div></div></div></div></div></div></div>";
	$("body").append(block);
	var document_height = $(document).height();
	$('.modal-window').height(document_height);
	var modalHeight = $('.modal-block').height();
	if(modalHeight < 100)
	{
		modalHeight = 450;
	}
	var top = (screen.height-modalHeight)/2;
	$('.modal-window .wrap-out').css({'top':top});
	$('.modal-window').animate({
		opacity: 1
	}, 400);
	modal_windows_close();
}

function modal_windows_close() {
	$(document).on('click', '.modal-block .close', function()
		{
		if ($(".modal-window").length) {
			$(".modal-window").fadeOut(400, function() {
				$(this).remove();
			});
		} else {
			$(".window-without-bg").hide(0, function() {
				$(this).remove();
			});
		}
	});
	$(document).on('click', '.modal-window', function(event) {
		if ($(event.target).closest(".modal-block").length) return;
		$(".modal-window").fadeOut(400, function() {
			$(this).remove();
		});
	});
}

function modalLoadBasket(openUrl, class_) {
	$.ajax({
		url: openUrl,
		cache: false,
		success: function(html) {
			modal_basket_show(html, class_);
		}
	});
}

function modal_basket_show(content, class_) {
	var block = "<div class='window-without-bg " + class_ + "'>" + "<div class='modal-block'>" + "<div class='modal-block-inner'><span class='close'></span><div class='modal-content'>" + content + "</div></div></div></div>";
	$("#basket").append(block);
	var h_basket = $("#basket").innerHeight() + "px";
	$(".window_basket").css("top", h_basket);
	modal_basket_event()
	modal_windows_close();
}

function modal_basket_event() {
	$(document).on('mouseenter', '.window_basket .basket-item', function() {
		$('.window_basket .basket-item .delete').hide();
		$(this).children(".delete").show();
	});
	$(document).on('mouseleave', '.window_basket .basket-item', function() {
		$('.window_basket .basket-item .delete').hide();
	});
	$(document).on('mouseenter', '.window_basket .basket-item .delete', function() {
		$(this).next(".item-tovar").addClass("del");
	});
	$(document).on('mouseleave', '.window_basket .basket-item .delete', function() {
		$(this).next(".item-tovar").removeClass("del");
	});
}

function remove_modal_basket_event() {
	$(".window_basket .basket-item").off("mouseenter");
	$(".window_basket .basket-item").off("mouseleave");
	$(".window_basket .basket-item .delete").off("mouseenter");
	$(".window_basket .basket-item .delete").off("mouseleave");
}

$(document).on('change', 'input[type="checkbox"]', function() {
	var this_ = $(this);
	change_label_checkbox(this_);
});

function change_label_checkbox(this_) {
	var cheked_ = $(this_).prop('checked');
	if (cheked_) {
		$(this_).siblings('label').addClass("label-active");
	} else {
		$(this_).siblings('label').removeClass("label-active");
	}
}
$(document).on('change', 'input[type="radio"]', function() {
	var this_ = $(this);
	change_label_radio(this_);
});

function change_label_radio(this_) {
	$(this_).parents('.js_radio').find('label').removeClass("label-active");
	$(this_).siblings('label').addClass("label-active");
}

function open_hide_items(this_, ul_inner_class) {
	var HideMenu = $(this_).closest(ul_inner_class).find('.childmenu-hide');
	$(HideMenu).slideToggle("slow", function() {});
}

function open_close_menu(this_, ul_inner_class,blank)
{

	$(this_).siblings(ul_inner_class).stop(true, false).slideToggle("slow", function()
	{
		if(blank)
		{
			$('.blank_list_in_menu').getNiceScroll().resize();
			//$('.blank_list_in_menu').niceScroll().updateScrollBar();
		}
		else
		{
			$Scroll = $(this_).closest('.scrollbarY');
			if ($Scroll.length > 0)
			{
				$Scroll.find('.overview').niceScroll({cursoropacitymin: 1, cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
			}
		}
	});

	$(this_).parent('.dropdown').toggleClass('li-open');
	if(blank)
	{}
	else
	{
		if ($(this_).siblings(".scrollbarY").length)
		{
			$(this_).siblings('.scrollbarY').find('.overview').niceScroll({cursoropacitymin: 1, cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
		}
	}
}
$(window).bind("resize", function()
{
	$("#block_menu_filter .scrollbarY").each(function() {
		open_menu_filter();
		var this_ = $(this);
		//block_viewport_h(this_);
		$(this).find('.overview').niceScroll({cursoropacitymin: 1, cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
		/*$(this).tinyscrollbar({
			thumbSize: 16
		});*/
		setTimeout(function() {
			close_noactive_menu();
		}, 10);
	});
});

function open_close_filter(this_, block_inner_class, block_wrap_class, close_other)
{
	if(close_other)
	{
		var isBlank = false;
		if($('.blank_filter'))
		{
			isBlank = true;
			var Url=$('.blank_filter').data('site-url');
		}
		$(block_wrap_class).each(function(){
			if($(this_).parent().attr('data-code') != $(this).attr('data-code'))
			{
				$(this).removeClass('block_open');
				$(this).find(block_inner_class).stop(true, false).slideUp("slow");
				if(isBlank)
				{
					var Code = $(this).data('code');
					var Open = 'N';
					$.ajax({
						type: 'POST',
						url: SITE_DIR + 'include/ajax/filter.php',
						data: {Url:Url,Code:Code,Open:Open},
						success: function(data){},
						error:  function (jqXHR, exception) {}
					});
				}
			}
		});

	}

	$(this_).next(block_inner_class).stop(true, false).slideToggle("slow");
	$(this_).parent(block_wrap_class).toggleClass('block_open');



	if ($(this_).next(".scrollbarY").length)
	{
		if($(this_).closest('#wrapper_blank_resizer'))
		{
			$(this_).next('.scrollbarY').find('.overview').niceScroll({cursoropacitymin: 1, cursorfixedheight:'16', horizrailenabled:false,cursordragontouch:true});
		}
		else
		{
			$(this_).next('.scrollbarY').find('.overview').niceScroll({cursoropacitymin: 1, cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
		}
	}
}
function close_filter() {
	$('#block_menu_filter .block_form_filter .filter_block.block_open .inner_filter_block').hide();
	$('#block_menu_filter .block_form_filter .filter_block.block_open').removeClass('block_open');
}

function open_menu_filter() {
	$('#block_menu_filter .block_form_filter .filter_block .scrollbarY').show();
	$('#block_menu_filter .block_form_filter .filter_block .scrollbarY').parents('.filter_block').addClass('block_open');
	$('#block_menu_filter .block_left_menu .dropdown .scrollbarY').show();
	$('#block_menu_filter .block_left_menu .dropdown .scrollbarY').parents('.dropdown').addClass('li-open');
}

function close_noactive_menu() {
	$('#block_menu_filter .block_left_menu .dropdown:not(.li-active) .inner-menu').hide();
	$('#block_menu_filter .block_left_menu .dropdown:not(.li-active)').removeClass('li-open');
}

function pluc_quantity(id_input) {
	var input_val = $(id_input).val();
	var input_val = parseInt(input_val) + 1;
	$(id_input).val(input_val);
	var row = id_input.replace('#QUANTITY_','');
	var id = $(id_input).data('offer');
}

function minus_quantity(id_input) {
	var input_val = $(id_input).val();
	if (input_val > 1) {
		var input_val = parseInt(input_val) - 1;
		$(id_input).val(input_val);
	}
}

function del_basket_item(id_item) {
	$(id_item).children('.row').slideUp("slow", function() {
		$(id_item).remove();
	});
	return false;
}

function open_close_block(this_, id_tab) {
	$(id_tab).slideToggle(400, function() {
		$(this_).toggleClass("close");
		$(this_).toggleClass("open");
	});
}

function go_offer_book(this_) {
	var btn_offset = $(this_).offset();
	var btn_height = $(this_).outerHeight(true);
	var scrolltop = btn_offset.top + btn_height + 10;
	$('html, body').animate({
		scrollTop: scrolltop
	}, 'slow');
}
$(window).on("resize", function() {
	if ($('html').width() >= 751) {
		height_section();
	} else {
		$('.js_wrap_section .section').height('auto');
	};
});

function height_section()
{
	$(".js_wrap_section").each(function() {
		$('.section:eq(0)', this).css("height", "auto");
		$('.section:eq(1)', this).css("height", "auto");
		var height1 = $('.section:eq(0)', this).outerHeight();
		var height2 = $('.section:eq(1)', this).outerHeight();
		if (height1 > height2) {
			$('.section:eq(1)', this).css("height", height1);
		} else {
			$('.section:eq(0)', this).css("height", height2);
		}
	});
}

function height_catalog_row()
{
	$(".b2b__catalog .b2b__header__name__value").each(function(i, elem) {

		var height1 = $(elem).outerHeight();
		var height2 = $('.b2b__catalog .b2b__header__params__props__value').eq(i).outerHeight();
		if (height1 > height2) {
			 $(elem).css("height", height1);
			 $('.b2b__catalog .b2b__header__quantity__value').eq(i).css("height", height1);
			 $('.b2b__catalog .b2b__header__params__props__value').eq(i).css("height", height1);
		} else {
			$(elem).css("height", height2);
			$('.b2b__catalog .b2b__header__quantity__value').eq(i).css("height", height2);
			$('.b2b__catalog .b2b__header__params__props__value').eq(i).css("height", height2);
		}
	});
}
function height_catalog_title(){
	var arr = new Array()
	$('.b2b__catalog .b2b__header__title').each(function (i, elem) {
		var height =  $(elem).outerHeight();
		arr[i] = height;
	});
	var all_height = 40;
	all_height = Math.max.apply(null, arr);

	$('.b2b__catalog .b2b__header__title').css("height", all_height);
}



function open_small_modal(this_, class_, content, is_hover) {
	var class_modal = "." + class_;
	var boolHover = false;
	$(".miss_small_modal").remove();
	if (!$(class_modal).length) {
		var block = "<span class='miss_small_modal bootstrap_style " + class_ + "'><span class='wrap_text'>" + content + "</span></span>";
		if (this_.is("input")) this_ = this_.parent();
		this_.append(block);
		var height_modal = $(class_modal).height();
		var position = this_.offset();
		$(document).on("click", class_modal, function(e) {
			e.preventDefault();
			$(this).fadeOut(400, function() {
				$(this).remove();
			});
			return false;
		})
		$(class_modal).css({
			'margin-top': -height_modal
		});
		$(class_modal).animate({
			opacity: 1
		}, 400);
		if (typeof is_hover != "undefined") {
			$(document).on("mouseleave", "." + this_.attr("class"), function(e) {
				$(class_modal).fadeOut(400, function() {
					$(class_modal).remove();
				});
			})
		} else setTimeout(function() {
			$(class_modal).fadeOut(400, function() {
				$(class_modal).remove();
			});
		}, 4000);
	}
}
$(window).bind("resize", function() {
	$('.brand_list > .row .brand_cart_wrap').height('auto');
	if ($('html').width() >= 751) {
		h_brand_cart_wrap();
	}
});

function h_brand_cart_wrap() {
	$('.brand_list > .row').each(function() {
		var h_brand_cart = 0;
		$(this).children('div').each(function() {
			var this_h = $(this).find('.brand_cart_wrap').height();
			if (this_h > h_brand_cart) {
				h_brand_cart = this_h;
			}
		});
		$(this).find('.brand_cart_wrap').height(h_brand_cart);
	});
};

function zoom_detail_img() {
	var slider_small = "";
	if ($('.wrap_pic_js .js_slider_pic_small').length) {
		$('.wrap_pic_js .js_slider_pic_small').css({
			'max-width': '375px',
			'width': '100%'
		});
		var CntVideoEl = $('.wrap_pic_js .js_slider_pic_small .item-video').length;
		var CntImgEl = $('.wrap_pic_js .js_slider_pic_small .item').length;
		var CntEl = CntVideoEl + CntImgEl;
		if ((($('html').width() >= 979 && CntEl > 6) || ($('html').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length == 0) || (($('.fancybox-wrap .preview').width() >= 979 && CntEl > 6) || ($('.fancybox-wrap .preview').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length > 0)) {
			$(".wrap_pic_js .js_slider_pic_small").owlCarousel({
				nav: true,
				smartSpeed: 400,
				dots: false,
				navText: ["", ""],
				responsive: {
					0: {
						items: 4
					},
					979: {
						items: 6
					}
				}
			});
		}
		slider_small = $('.wrap_pic_js .js_slider_pic_small').data('owlCarousel');
	}

	$('.zoomIt_zoomed').remove();
	$('.wrap_pic_js .zoomIt_area').remove();
	$('.wrap_pic_js .zoomIt_loaded').removeClass("zoomIt_loaded");
	if ($('html').width() >= 751 && $('.wrap_pic_js .big_foto:visible').length) {
		setTimeout(function() {
			$('.wrap_pic_js .big_foto:visible').jqZoomIt({
				multiplierX: 1.36,
				multiplierY: 1,
				zoomAreaOpacity: 1,
				zoomDistance: 22,
				zoomClass: 'zoomIt_zoomed',
				zoomAreaClass: 'zoomIt_area',
				init: function() {
					$(this).addClass('zoomIt_loaded');
				}
			});
		}, 300);
	}
	var big_foto = "";
	if ($('.wrap_pic_js .detail_pic_small').length) {
		$(document).on('mouseleave', '.wrap_pic_js .big_foto', function() {
			$('.zoomIt_zoomed:visible').fadeOut('400', function() {
				$(this).css({
					'top': -5000,
					'left': -5000
				});
			});
			$('.wrap_pic_js .zoomIt_area:visible').hide();
		});
		$(document).on('mouseenter touchstart', '.wrap_pic_js .detail_pic_small  .item:not(.item_active)', function() {
			$(this).parents('.detail_pic_small').find(".item.item_active").removeClass("item_active");
			$(this).addClass("item_active");
			if (big_foto) {
				big_foto.stop(true, true);
			}
			if ($(".wrap_pic_js .detail_pic_small .active").length > 0) var this_index = $(".wrap_pic_js .detail_pic_small .owl-item .item").index(this);
			else var this_index = $(".wrap_pic_js .detail_pic_small .item").index(this);
			prev_foto = $(this).parents('.wrap_pic_js').find('.big_foto:visible').css({
				'z-index': '0',
				'display': 'block'
			});
			big_foto = $(this).parents('.wrap_pic_js').find('.big_foto').eq(this_index).css({
				'position': 'absolute',
				'z-index': '8'
			}).fadeIn(600, function() {
				prev_foto.css({
					'display': 'none',
					'position': 'absolute'
				});
				$(this).css({
					'display': 'block'
				});
				$(this).css({
					'position': 'relative'
				});
			});
			var window_w = $(window).width() + 17;
			if (window_w > 767) {
				if (!$(big_foto).hasClass('zoomIt_loaded')) {
					$(big_foto).jqZoomIt({
						multiplierX: 1.36,
						multiplierY: 1,
						zoomAreaOpacity: 1,
						zoomDistance: 22,
						zoomClass: 'zoomIt_zoomed',
						zoomAreaClass: 'zoomIt_area',
						init: function() {
							$(this).addClass('zoomIt_loaded');
						}
					});
				}
			}
		});
	};
	if ($('html').width() >= 751 && $('.wrap_pic_js').length) {
		$(document).off('mousewheel', '.wrap_pic_js');
		$(document).on('mousewheel', '.wrap_pic_js', function(event, delta, deltaX, deltaY) {
			event.preventDefault();
			var active_item = $('.wrap_pic_js .detail_pic_small  .item.item_active');
			var area_position = $('.wrap_pic_js .big_foto:visible .zoomIt_area:visible').position();
			if (active_item.parent('.owl-item').length > 0) {
				if (deltaY == "-1") {
					active_item.parent('.owl-item').prev('.owl-item').children('.item').mouseenter();
				} else if (deltaY == "1") {
					active_item.parent('.owl-item').next('.owl-item').children('.item').mouseenter();
				}
			} else {
				if (deltaY == "-1") {
					active_item.prev().mouseenter();
				} else if (deltaY == "1") {
					active_item.next().mouseenter();
				}
			}
			$('.wrap_pic_js .big_foto .zoomIt_area').css({
				'top': area_position.top,
				'left': area_position.left
			});
			var new_item = $('.wrap_pic_js .detail_pic_small  .item.item_active');
			var new_item_index = $(".wrap_pic_js .detail_pic_small  .item").index(new_item);
			var CntVideoEl = $('.wrap_pic_js .js_slider_pic_small .item-video').length;
			var CntImgEl = $('.wrap_pic_js .js_slider_pic_small .item').length;
			var CntEl = CntVideoEl + CntImgEl;
			if ((($('html').width() >= 979 && CntEl > 6) || ($('html').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length == 0) || (($('.fancybox-wrap .preview').width() >= 979 && CntEl > 6) || ($('.fancybox-wrap .preview').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length > 0)) {
				slider_small.trigger("to.owl.carousel", [new_item_index, 1, true]);
			}
		});
	};
	$(window).bind("resize", function() {
		$('.zoomIt_zoomed').remove();
		$('.wrap_pic_js .zoomIt_area').remove();
		$('.wrap_pic_js .zoomIt_loaded').removeClass("zoomIt_loaded");
		if ($('html').width() >= 751 && $('.wrap_pic_js .big_foto:visible').length) {
			$('.wrap_pic_js .big_foto:visible').jqZoomIt({
				multiplierX: 1.36,
				multiplierY: 1,
				zoomAreaOpacity: 1,
				zoomDistance: 22,
				zoomClass: 'zoomIt_zoomed',
				zoomAreaClass: 'zoomIt_area',
				init: function() {
					$(this).addClass('zoomIt_loaded');
				}
			});
		}
	});
};

function zoom_quick_view_img(class_wrap_bl) {
	var slider_small = "";
	if ($(class_wrap_bl + ' .js_slider_pic_small').length) {
		var CntVideoEl = $(class_wrap_bl + ' .js_slider_pic_small .item-video').length;
		var CntImgEl = $(class_wrap_bl + ' .js_slider_pic_small .item').length;
		var CntEl = CntVideoEl + CntImgEl;
		if ((($('html').width() >= 979 && CntEl > 6) || ($('html').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length == 0) || (($('.fancybox-wrap .preview').width() >= 979 && CntEl > 6) || ($('.fancybox-wrap .preview').width() < 979 && CntEl > 4) && $('.fancybox-wrap .preview').length > 0)) {
			$(class_wrap_bl + ' .js_slider_pic_small').css({
				'max-width': '375px',
				'width': '100%'
			});
			$('.preview .js_slider_pic_small').owlCarousel({
				nav: true,
				smartSpeed: 400,
				dots: false,
				navText: ["", ""],
				items: 4,
			});
			slider_small = $(class_wrap_bl + ' .js_slider_pic_small').data('owlCarousel');
		}
	}
	$('.zoomIt_quick_zoomed').remove();
	$(class_wrap_bl + ' .zoomIt_area').remove();
	$(class_wrap_bl + ' .zoomIt_loaded').removeClass("zoomIt_loaded");
	if ($('html').width() >= 751 && $(class_wrap_bl + ' .big_foto:visible').length) {
		setTimeout(function() {
			$(class_wrap_bl + ' .big_foto:visible').jqZoomIt({
				multiplierX: 1.36,
				multiplierY: 1,
				zoomAreaOpacity: 1,
				zoomDistance: 22,
				zoomClass: 'zoomIt_quick_zoomed',
				zoomAreaClass: 'zoomIt_area',
				init: function() {
					$(this).addClass('zoomIt_loaded');
				},
				zoom: function()
				{
					$('.fancybox-inner').scrollTop();
					// console.log($('.fancybox-inner').scrollTop());
				}
			});
		}, 300);
	}
	var big_foto = "";
	if ($(class_wrap_bl + ' .detail_pic_small').length) {
		$(document).on('mouseleave', class_wrap_bl + ' .big_foto', function() {
			$('.zoomIt_zoomed:visible').fadeOut('400', function() {
				$(this).css({
					'top': -5000,
					'left': -5000
				});
			});
			$(class_wrap_bl + ' .zoomIt_area:visible').hide();
		});
		$(document).on('mouseenter', class_wrap_bl + ' .detail_pic_small  .item:not(.item_active)', function() {
			$(this).parents('.detail_pic_small').find(".item.item_active").removeClass("item_active");
			$(this).addClass("item_active");
			if (big_foto) {
				big_foto.stop(true, true);
			}
			if ($(class_wrap_bl + " .detail_pic_small .active").length > 0) var this_index = $(class_wrap_bl + " .detail_pic_small .owl-item .item").index(this);
			else var this_index = $(class_wrap_bl + " .detail_pic_small .item").index(this);
			prev_foto = $(this).parents(class_wrap_bl).find('.big_foto:visible').css({
				'z-index': '0',
				'display': 'block'
			});
			big_foto = $(this).parents(class_wrap_bl).find('.big_foto').eq(this_index).css({
				'position': 'absolute',
				'z-index': '8'
			}).fadeIn(600, function() {
				prev_foto.css({
					'display': 'none',
					'position': 'absolute'
				});
				$(this).css({
					'display': 'block'
				});
				$(this).css({
					'position': 'relative'
				});
			});
			if ($('html').width() >= 751) {
				if (!$(big_foto).hasClass('zoomIt_loaded')) {
					$(big_foto).jqZoomIt({
						multiplierX: 1.36,
						multiplierY: 1,
						zoomAreaOpacity: 1,
						zoomDistance: 22,
						zoomClass: 'zoomIt_quick_zoomed',
						zoomAreaClass: 'zoomIt_area',
						init: function() {
							$(this).addClass('zoomIt_loaded');
						}
					});
				}
			}
		});
	};
	if ($('html').width() >= 751 && $(class_wrap_bl).length) {
		$(document).off('mousewheel', class_wrap_bl);
		$(document).on('mousewheel', class_wrap_bl, function(event, delta, deltaX, deltaY) {
			event.preventDefault();
			var active_item = $(class_wrap_bl + ' .detail_pic_small  .item.item_active');
			var area_position = $(class_wrap_bl + ' .big_foto:visible .zoomIt_area:visible').position();
			if (deltaY == "-1") {
				active_item.parent('.owl-item').prev('.owl-item').children('.item').mouseenter();
			} else if (deltaY == "1") {
				active_item.parent('.owl-item').next('.owl-item').children('.item').mouseenter();
			}
			$(class_wrap_bl + ' .big_foto .zoomIt_area').css({
				'top': area_position.top,
				'left': area_position.left
			});
			var new_item = $(class_wrap_bl + ' .detail_pic_small  .item.item_active');
			var new_item_index = $(class_wrap_bl + ' .detail_pic_small  .item').index(new_item);
			slider_small.trigger("to.owl.carousel", [new_item_index, 1, true]);
		});
	};
	$(window).bind("resize", function() {
		$('.zoomIt_quick_zoomed').remove();
		$(class_wrap_bl + ' .zoomIt_area').remove();
		$(class_wrap_bl + ' .zoomIt_loaded').removeClass("zoomIt_loaded");
		if ($('html').width() >= 751 && $(class_wrap_bl + ' .big_foto:visible').length) {
			$(class_wrap_bl + ' .big_foto:visible').jqZoomIt({
				multiplierX: 1.36,
				multiplierY: 1,
				zoomAreaOpacity: 1,
				zoomDistance: 22,
				zoomClass: 'zoomIt_quick_zoomed',
				zoomAreaClass: 'zoomIt_area',
				init: function() {
					$(this).addClass('zoomIt_loaded');
				}
			});
		}
	});
};

function download_img(this_) {
	var href_ = $(this_).siblings('.big_foto:visible').attr('href');
	$(this_).attr('href', href_);
}

function newsCountShow(openUrl, id_element) {
	BX.ajax({
		url: openUrl,
		method: 'POST',
		dataType: 'html',
		data: 'AJAX=Y&addCounter=Y&id_element=' + id_element,
		success: function(data) {}
	});
}
$(document).one('mouseenter', '.wrap-main-top-menu .first-top-menu', function() {
	if ($('.first-top-menu-content .first-top-menu-content-menu-row').length < 2) {
		$('.first-top-menu-content .first-top-menu-content-menu-row .childmenu-hide').show();
		$('.hide-bottoms-text').hide();
	}
	var MaxTopHeight = 0;
	$('.first-top-menu-content .first-top-menu-content-menu-row').each(function() {
		var MaxHeight = 0;
		var MaxOldHeight = 0;
		$(this).find('.first-top-menu-content-menu-childmenu').each(function() {
			if (MaxHeight < $(this).height()) MaxHeight = $(this).height();
		});

		$(this).find('.first-top-menu-content-menu-childmenu').each(function() {
			var TmpHeight = parseInt(MaxHeight) + 30;
			$(this).css('min-height', TmpHeight);
		});
		$(this).find('.first-top-menu-content-menu .first-top-menu-content-menu-title-wrapper').each(function() {
			if (MaxTopHeight < $(this).height()) MaxTopHeight = $(this).height();
		});

		$(this).find('.first-top-menu-content-menu .first-top-menu-content-menu-title-wrapper').each(function() {
			$(this).height(MaxTopHeight);
		});
		$(this).find('.first-top-menu-content-menu').each(function() {
			if (MaxOldHeight < $(this).height()) MaxOldHeight = $(this).height();
		});
		if($('.first-top-menu-content .first-top-menu-content-menu-row').length < 2)
		{
			var NewHeight = parseInt(MaxOldHeight) + 30;
		}
		else
		{
			var NewHeight = parseInt(MaxHeight) + parseInt(MaxOldHeight) + 30;
		}
		$(this).find('.first-top-menu-content-menu').each(function() {
			$(this).height(NewHeight);
		});
	});
	$('.first-top-menu-content .first-top-menu-content-menu-row').each(function(index, val) {
		var NewZIndex = 9999 - index;
		$('.first-top-menu-content-menu-childmenu', this).css('z-index', NewZIndex);
	});
	var AllHeight = $('.first-top-menu-content').closest('.owl-stage').height();
	var OldHeight = $('.first-top-menu-content').height();
	if (OldHeight < AllHeight) {
		if ($('.first-top-menu-content .first-top-menu-content-menu-row').length > 1) {
			$('.first-top-menu-content .first-top-menu-content-menu-row:last-child').each(function() {
				var NewHeight = parseInt($(this).height()) + AllHeight - OldHeight;
				$(this).height(NewHeight);
				$('.first-top-menu-content .first-top-menu-content-menu-row:last-child .first-top-menu-content-menu').each(function() {
					$(this).height(NewHeight);
					var TitleHeight = $('.first-top-menu-content-menu-title-wrapper', this).height();
					var NewItemInnerHeight = NewHeight - TitleHeight;
				});
			});
		} else {
			$('.first-top-menu-content .first-top-menu-content-menu-row').each(function() {
				var NewHeight = parseInt($(this).height()) + AllHeight - OldHeight;
				$(this).height(NewHeight);
				$('.first-top-menu-content .first-top-menu-content-menu-row:last-child .first-top-menu-content-menu').each(function() {
					$(this).height(NewHeight);
					var TitleHeight = $('.first-top-menu-content-menu-title-wrapper', this).height();
					var NewItemInnerHeight = NewHeight - TitleHeight;
					$('.first-top-menu-content-menu-childmenu', this).height(NewItemInnerHeight);
				});
			});
		}
	}
});
$(window).load(function() {
	setTimeout(function() {
		$(window).on('popstate', function(e) {
			location.reload();
		});
	}, 0);
});
BX.ready(function() {
	BX.addCustomEvent("onAjaxSuccess", function(e, config)
	{
		if (config != null && config !== null && typeof config.method != "undefined") {
			ajaxFunction();
		} else if (config === null) {
			ajaxFunction();
		}
	});

	function ajaxFunction()
	{
		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		if (isMobile && $(".dsqv").length > 0) {
			$(".dsqv").removeAttr("class");
		}

		LazyLoad();

		if ($('#block_menu_filter').length)
		{
			/*$("#block_menu_filter .scrollbarY").each(function() {
				var this_ = $(this);
				block_viewport_h(this_);
			});*/
			$("#block_menu_filter .scrollbarY:visible").each(function()
			{

				$(this).find('.overview').niceScroll({cursoropacitymin: 1,cursorfixedheight:'16', cursorwidth:'16px',horizrailenabled:false,cursordragontouch:true});
				/*$(this).tinyscrollbar({
					thumbSize: 16
				});*/
			});
		}

		if ($('.icon_property_wrap').length)
		{
			icon_position('.icon_property_wrap');
		}

		if ($('#section_list').length)
		{
			/*if ($('#section_list .icon_property_wrap').length) {
				icon_position('#section_list .icon_property_wrap');
			}*/
			$(function() {
				if (!$.browser.safari) $('.wrap_select_sort select').ikSelect();
			});
			$(function() {
				if (!$.browser.safari) $('.wrap_select_number select').ikSelect();
			});
		}
		if ($('.wrap_pic_js').length) {
			zoom_detail_img();
		}
		$('input[type="checkbox"]').each(function() {
			change_label_checkbox(this);
		});
		$('input[type="radio"]').each(function() {
			var cheked_ = $(this).prop('checked');
			if (cheked_) {
				change_label_radio(this);
			}
		});
		if ($(".js_wrap_section").length) {
			if ($('html').width() >= 751) {
				height_section();
			}
		}
	}
});
////////BASKET/////////
function BitrixSmallCart() {}
BitrixSmallCart.prototype = {
	activate: function() {
		this.addBask = false;
		this.cartElement = BX(this.cartId);
		this.fixedPosition = this.arParams.POSITION_FIXED == 'Y';
		if (this.fixedPosition) {
			this.cartClosed = true;
			this.maxHeight = false;
			this.itemRemoved = false;
			this.verticalPosition = this.arParams.POSITION_VERTICAL;
			this.horizontalPosition = this.arParams.POSITION_HORIZONTAL;
			this.topPanelElement = BX("bx-panel");
			this.OldCnt = 0;
			this.NewCnt = 0;
			this.fixAfterRender();
			this.fixAfterRenderClosure = this.closure('fixAfterRender');
			var fixCartClosure = this.closure('fixCart');
			this.fixCartClosure = fixCartClosure;
			if (this.topPanelElement && this.verticalPosition == 'top') BX.addCustomEvent(window, 'onTopPanelCollapse', fixCartClosure);
			var resizeTimer = null;
			BX.bind(window, 'resize', function() {
				clearTimeout(resizeTimer);
				resizeTimer = setTimeout(fixCartClosure, 200);
			});
		}
		this.setCartBodyClosure = this.closure('setCartBody');
		BX.addCustomEvent(window, 'OnBasketChange', this.closure('refreshCart', {}));
	},
	fixAfterRender: function() {
		this.statusElement = BX(this.cartId + 'status');
		if (this.statusElement) {
			if (this.cartClosed) this.statusElement.innerHTML = this.openMessage;
			else this.statusElement.innerHTML = this.closeMessage;
		}
		this.productsElement = BX(this.cartId + 'products');
		this.fixCart();
	},
	closure: function(fname, data) {
		var obj = this;
		return data ? function() {
			obj[fname](data)
		} : function(arg1) {
			obj[fname](arg1)
		};
	},
	toggleOpenCloseCart: function(action) {
		if (action == "open") this.cartClosed = true;
		else this.cartClosed = false
		if (this.cartClosed) {
			BX.removeClass(this.cartElement, 'bx-closed');
			BX.addClass(this.cartElement, 'bx-opener');
			BX.addClass(this.cartElement, 'bx-max-height');
			
			if (this.addBask) $('.window-without-bg').css('display', 'none');
			else $('.window-without-bg').css('display', 'block');
			this.cartClosed = false;
			this.fixCart();
		} else {
			$('.window-without-bg').slideUp(1000);
			BX.addClass(this.cartElement, 'bx-closed');
			BX.removeClass(this.cartElement, 'bx-opener');
			BX.removeClass(this.cartElement, 'bx-max-height');
			this.cartClosed = true;
			var itemList = this.cartElement.querySelector("[data-role='basket-item-list']");
		}
		setTimeout(this.fixCartClosure, 100);
	},
	setVerticalCenter: function(windowHeight) {
		var top = windowHeight / 2 - (this.cartElement.offsetHeight / 2);
		if (top < 5) top = 5;
		this.cartElement.style.top = top + 'px';
	},
	fixCart: function() {
		if (this.addBask) {
			$('.window-without-bg').slideDown(1000);
		}
		if (this.horizontalPosition == 'hcenter') {
			var windowWidth = 'innerWidth' in window ? window.innerWidth : document.documentElement.offsetWidth;
			var left = windowWidth / 2 - (this.cartElement.offsetWidth / 2);
			if (left < 5) left = 5;
			this.cartElement.style.left = left + 'px';
		}
		var windowHeight = 'innerHeight' in window ? window.innerHeight : document.documentElement.offsetHeight;
		switch (this.verticalPosition) {
			case 'top':
				if (this.topPanelElement) this.cartElement.style.top = this.topPanelElement.offsetHeight + 5 + 'px';
				break;
			case 'vcenter':
				this.setVerticalCenter(windowHeight);
				break;
		}
		if (this.productsElement) {
			var itemList = this.cartElement.querySelector("[data-role='basket-item-list']");
			if (this.cartClosed) {
				if (this.maxHeight) {
					BX.removeClass(this.cartElement, 'bx-max-height');
					if (itemList) itemList.style.top = "auto";
					this.maxHeight = false;
				}
			} else {
				if (this.maxHeight) {
					if (this.productsElement.scrollHeight == this.productsElement.clientHeight) {
						BX.removeClass(this.cartElement, 'bx-max-height');
						if (itemList) itemList.style.top = "auto";
						this.maxHeight = false;
					}
				} else {
					if (this.verticalPosition == 'top' || this.verticalPosition == 'vcenter') {
						if (this.cartElement.offsetTop + this.cartElement.offsetHeight >= windowHeight) {
							BX.addClass(this.cartElement, 'bx-max-height');
							if (itemList) itemList.style.top = 82 + "px";
							this.maxHeight = true;
						}
					} else {
						if (this.cartElement.offsetHeight >= windowHeight) {
							BX.addClass(this.cartElement, 'bx-max-height');
							if (itemList) itemList.style.top = 82 + "px";
							this.maxHeight = true;
						}
					}
				}
			}
			if (this.verticalPosition == 'vcenter') this.setVerticalCenter(windowHeight);
		}
	},
	refreshCart: function(data) {
		if (this.itemRemoved) {
			this.itemRemoved = false;
			return;
		}
		this.OldCnt = $(".modal-content .item-bg-1").length;
		if (data.sbblRemoveItemFromCart != "undefined" && data.sbblRemoveItemFromCart > 0) {
			this.addBask = false;
		} else {
			this.addBask = true;
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
	setCartBody: function(result) {
		if (this.cartElement) this.cartElement.innerHTML = result;
		if (this.fixedPosition) setTimeout(this.fixAfterRenderClosure, 100);
		this.NewCnt == $(".modal-content .item-bg-1").length;
		//this.toggleOpenCloseCart("open");
	},
	removeItemFromCart: function(id) {
		this.refreshCart({
			sbblRemoveItemFromCart: id
		});
		this.itemRemoved = true;
		BX.onCustomEvent('OnBasketChange');
	}
};

function OneHeight(obj) {
	var MinHeight = 0;
	var NeedSetOneHeight = false;
	obj.find('.one-item').each(function(key, value) {
		var ImgWidth = $('.item-top-part img', this).attr('width');
		var ImgHeight = $('.item-top-part img', this).attr('height');
		var BlockWidth = $('.item-top-part img', this).width();
		var koef = BlockWidth / ImgWidth;
		var BlockHeight = koef * ImgHeight;
		if (MinHeight != 0 && BlockHeight != MinHeight) {
			NeedSetOneHeight = true;
		}
		if (BlockHeight > MinHeight) {
			MinHeight = BlockHeight;
		}
	});
	if (NeedSetOneHeight) {
		var rtrn = MinHeight;
	} else {
		var rtrn = false;
	}
	return rtrn;
};
/////////PRODUCT//////////
(function(window, document, $, undefined) {
	window.msDetailProduct = function(arParams) {
		this.OffersProps = "";
		this.SITE_ID = "";
		this.COLOR_UL = "";
		this.COLOR_UL_HOR = "";
		this.ModifSizeCol = "";
		this.js_slider_pic_small = "";
		this.modalUrl = "";
		this.modalData = "";
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
		this.arImage2 = "";
		this.arImage2need = "";
		this.arVideo = "";
		this.TemplatePath = "";
		this.propColor = "";
		this.added_to_basket = "";
		this.xmlID = "";
		this.main = "";
		this.offerID = 0;
		this.add_url = "";
		this.add_wish = "";
		this.add_subscribe = "";
		this.basket_url = "";
		this.basketPath = "";
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
		this.Wrapper = "";
		this.contSelectProps = "";
		this.btn_class = "";
		this.btn_basket = "";
		this.btn_change_class = "";
		this.this_ = this;
		if ('object' === typeof arParams) {
			this.OffersProps = arParams.OffersProps;
			this.SITE_ID = arParams.SITE_ID;
			this.COLOR_UL = arParams.COLOR_UL;
			this.COLOR_UL_HOR = arParams.COLOR_UL_HOR;
			this.ModifSizeCol = arParams.ModifSizeCol;
			this.js_slider_pic_small = arParams.js_slider_pic_small;
			this.PRODUCT_ID = arParams.PRODUCT_ID;
			this.offerID = arParams.OFFER_ID;
			this.DETAIL_PAGE_URL = arParams.DETAIL_PAGE_URL;
			this.container = arParams.prop + " " + arParams.child_prop;
			this.ul = arParams.prop;
			this.li = arParams.child_prop;
			this.classLiActive = arParams.class_li_active;
			this.classLiDesabled = arParams.class_li_disable;
			this.classLiAvailable = arParams.class_li_available;
			this.imgContainer = arParams.image_container;
			this.Wrapper = arParams.Wrapper;
			this.priceContainer = arParams.main + " " + arParams.price_container;
			this.availableContainer = arParams.main + " " + arParams.available_container;
			this.quantityInput = arParams.main + " " + arParams.quantity_input;
			this.arImage = arParams.image;
			this.arImage2 = arParams.image2;
			this.arImage2need = arParams.image2need;
			this.basketPath = arParams.basketPath;
			this.arVideo = arParams.video;
			this.TemplatePath = arParams.TemplatePath;
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
			this.added_to_basket = arParams.added_to_basket;
			this.contSelectProps = arParams.contSelectProps;
			this.prices = arParams.prices;
			this.discountPrice = arParams.discountPrice;
			this.oldPrice = arParams.oldPrice;
			this.download = arParams.download;
			this.ModificationToggle = arParams.ModificationToggle;
			this.ModificationTextToggle = arParams.ModificationTextToggle;
			this.ModificationMoreText = arParams.ModificationMoreText;
			this.ModificationShowAll = arParams.ModificationShowAll;
			this.ModificationMinus = arParams.ModificationMinus;
			this.ModificationPlus = arParams.ModificationPlus;
			this.ModificationAddBasket = arParams.ModificationAddBasket;
			this.PlayVideo = arParams.PlayVideo;
			this.CloseVideo = arParams.CloseVideo;
			this.modalUrl = arParams.modalUrl;
			this.modalData = arParams.modalData;
			this.btn_class = arParams.btn_class;
			this.btn_change_class = arParams.btn_change_class;
			this.btn_basket = arParams.btn_basket;
		}
		this.destroy(this);
		this.init(this);
		this.counter(this);
	};
	window.msDetailProduct.prototype.init = function(_this)
	{
		if ($(".full-width-description").length)
		{
			var LeftHeight = $(".full-width-description #left .detail_description").height();
			var RightHeight = $(".full-width-description #right .detail_description").height();
			if (LeftHeight > RightHeight) {
				$(".full-width-description #right .detail_description").height(LeftHeight);
			} else {
				$(".full-width-description #left .detail_description").height(RightHeight);
			}
		}

		$(document).on("click touchstart", _this.container, _this, _this.clickProp);
		$(document).on("click", _this.add_url, _this, _this.clickAddBasket);
		$(document).on("click", _this.add_wish, _this, _this.clickAddWish);
		$(document).on("mouseenter", _this.contPrevNext + " " + _this.contPrev, _this, _this.prevProduct);
		$(document).on("mouseenter", _this.contPrevNext + " " + _this.contNext, _this, _this.prevProduct);
		$(document).on("mouseenter", _this.add_url, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.add_wish, _this, _this.checkStringProps);
		$(document).on("mouseenter", _this.contSelectProps, _this, _this.checkStringProps);
		$(document).on("click", _this.ModificationToggle, _this, _this.clickModificationToggle);
		$(document).on("click", _this.ModificationTextToggle, _this, _this.clickModificationTextToggle);
		$(document).on("click", _this.ModificationMoreText, _this, _this.clickModificationShowAll);
		$(document).on("click", _this.ModificationShowAll, _this, _this.clickModificationShowAll);
		$(document).on("click", _this.ModificationMinus, _this, _this.clickModificationMinus);
		$(document).on("click", _this.ModificationPlus, _this, _this.clickModificationPlus);
		$(document).on("click", _this.ModificationAddBasket, _this, _this.clickModificationAddBasket);
		$(document).on("click", _this.PlayVideo, _this, _this.clickPlayVideo);
		$(document).on("click", _this.CloseVideo, _this, _this.clickCloseVideo);
	};
	window.msDetailProduct.prototype.destroy = function() {
		$(document).off("click touchstart", this.container, this.clickProp);
		$(document).off("click", this.add_url, this.clickAddBasket);
		$(document).off("click", this.add_wish, this.clickAddWish);
		$(document).off("mouseenter", this.contPrevNext + " " + this.contPrev, this.prevProduct);
		$(document).off("mouseenter", this.contPrevNext + " " + this.contNext, this.prevProduct);
		$(document).off("mouseenter", this.add_url, this.checkStringProps);
		$(document).off("mouseenter", this.add_wish, this.checkStringProps);
		$(document).off("mouseenter", this.add_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.submit_subscribe, this.checkStringProps);
		$(document).off("mouseenter", this.contSelectProps, this.checkStringProps);
		$(document).off("click", this.ModificationToggle, this.clickModificationToggle);
		$(document).off("click", this.ModificationTextToggle, this.clickModificationTextToggle);
		$(document).off("click", this.ModificationShowAll, this.clickModificationShowAll);
		$(document).off("click", this.ModificationMoreText, this.clickModificationShowAll);
		$(document).off("click", this.ModificationMinus, this.clickModificationMinus);
		$(document).off("click", this.ModificationPlus, this.clickModificationPlus);
		$(document).off("click", this.ModificationAddBasket, this.clickModificationAddBasket);
		$(document).off("click", this.PlayVideo, this.clickPlayVideo);
		$(document).off("click", this.CloseVideo, this.clickCloseVideo);
	};
	window.msDetailProduct.prototype.clickModificationToggle = function(e)
	{
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};
	window.msDetailProduct.prototype.clickModificationTextToggle = function(e)
	{
		$(this).next(".block_js").stop(true, false).slideToggle("slow");
		$(this).parent('.description_block').toggleClass('block_open');
	};
	window.msDetailProduct.prototype.clickModificationShowAll = function(e)
	{
		e.preventDefault();
		_this = e.data;
		if ($(this).closest('.col-modification').find(".item-row-hide").is(":hidden")) {
			$(this).closest('.col-modification').find(".item-row-hide").fadeIn();
			$(this).closest('.col-modification').find(".size-row-hide").fadeIn();
			$(this).closest('.col-modification').find(".show-all").html($(this).closest('.col-modification').find(".show-all").attr('data-hide'));
			$(this).closest('.col-modification').find(".more-text").html($(this).closest('.col-modification').find(".more-text").attr('data-hide'));
		} else {
			$(this).closest('.col-modification').find(".item-row-hide").fadeOut();
			$(this).closest('.col-modification').find(".size-row-hide").fadeOut();
			$(this).closest('.col-modification').find(".show-all").html($(this).closest('.col-modification').find(".show-all").attr('data-show'));
			$(this).closest('.col-modification').find(".more-text").html($(this).closest('.col-modification').find(".more-text").attr('data-show'));
		}
	};
	window.msDetailProduct.prototype.clickModificationMinus = function(e)
	{
		e.preventDefault();
		_this = e.data;
		var OldValue = parseInt($(this).siblings(".sizes-block-cnt-value").html());
		if (OldValue > 0) {
			$(this).siblings(".sizes-block-cnt-value").html(OldValue - 1);
			var OfferPrice = parseFloat($(this).closest(".size").find('.size-item-row-price').children().attr('data-offer-price'));
			var OldPrice = parseFloat($(this).closest('.col-modification').find("#modification-basket-price").html());
			var NewPrice = OldPrice - OfferPrice;
			if (NewPrice.toString().indexOf('.') >= 0) NewPrice = NewPrice.toFixed(2);
			$(this).closest('.col-modification').find("#modification-basket-price").html(NewPrice);
		}
	};
	window.msDetailProduct.prototype.clickModificationPlus = function(e)
	{
		e.preventDefault();
		_this = e.data;
		var OldValue = parseInt($(this).siblings(".sizes-block-cnt-value").html());
		$(this).siblings(".sizes-block-cnt-value").html(OldValue + 1);
		var OfferPrice = Number($(this).closest(".size").find('.size-item-row-price').children().attr('data-offer-price'));
		var OldPrice = Number($(this).closest('.col-modification').find("#modification-basket-price").html());
		var NewPrice = OldPrice + OfferPrice;
		if (NewPrice.toString().indexOf('.') >= 0) NewPrice = NewPrice.toFixed(2);
		$(this).closest('.col-modification').find("#modification-basket-price").html(NewPrice);
	};
	window.msDetailProduct.prototype.clickModificationAddBasket = function(e)
	{
		e.preventDefault();
		_this = e.data;
		cont_modal = $(this);
		if (Number($(this).closest('.col-modification').find("#modification-basket-price").html()) <= 0) {
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
			var arrOfferID = new Array();
			$(this).closest('.col-modification').find('.size').each(function(index, value) {
				var Cnt = parseInt($(this).find('.sizes-block-cnt-value').html());
				if (Cnt > 0) {
					var OfferId = parseInt($(this).find('.size-item-row-price').children().attr('data-offer-id'));
					arrOfferID.push(OfferId);
					url = _this.basket_url[OfferId] + "&quantity=" + Cnt;
					BX.ajax.loadJSON(url, function(data){
						if(data['STATUS'] == 'ERROR')
						{
							cont_modal.msTooltip({
								"class": "class_modification_tooltip",
								"message": data['MESSAGE'],
								"is_hover": true,
								"timeOut": true
							});
						}
						else
						{
							$('.sizes-block-cnt-value').html('0');
							$("#modification-basket-price").html('0');
							$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
								scrollTop: 0
							}, 1000, BX.onCustomEvent('OnBasketChange'));
						}
					}, "");
				}
			});
		}
	};
	window.msDetailProduct.prototype.clickPlayVideo = function(e) {
		e.preventDefault();
		_this = e.data;
		var key = $(this).attr('data-key');
		hidevideoDetail(_this.Wrapper);
		showvideoDetail(key, _this.Wrapper);
	};
	window.msDetailProduct.prototype.clickCloseVideo = function(e) {
		hidevideoDetail(_this.Wrapper);
	};
	hidevideoDetail = function(Wrapper) {
		$(Wrapper).find('.detail_big_video').hide();
		$(Wrapper).find('.detail_big_video').css("z-index", "1");
		$(Wrapper).find('.detail_big_pic .download_pic').show();
	}
	showvideoDetail = function(key, Wrapper) {
		$(Wrapper).find('.detail_big_pic .download_pic').hide();
		$(Wrapper).find('.detail_big_video:eq(' + key + ')').show();
		$(Wrapper).find('.detail_big_video:eq(' + key + ')').css("z-index", "9");
	}
	window.msDetailProduct.prototype.checkStringProps = function(e) {
		_this = e.data;
		strTitle = "";
		cont_modal = $(this);
		if (_this.offerID <= 0) {
			bool = true;
			$(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					if (bool) strTitle += $(this).attr("title");
					else strTitle += ", " + $(this).attr("title");
					bool = false;
				}
			})
			if (!bool) {
				cont_modal.msTooltip({
					"class": "class_check_props",
					"message": BX.message("MS_JS_CATALOG_SELECT_PROP") + " " + strTitle,
					"is_hover": true,
					"timeOut": true
				});
				return false;
			}
		}
		return true;
	};
	window.msDetailProduct.prototype.prevProduct = function(e) {
		params = "productAction=prev";
		_this = e.data;
		BX.ajax.post(_this.DETAIL_PAGE_URL, params, _this.successPrev);
	};
	window.msDetailProduct.prototype.successPrev = function(data) {console.log(data);
		$("#prev_next_product").html(data);
		$(document).off("mouseenter", _this.contPrevNext + " " + _this.contPrev, _this.prevProduct);
		$(document).off("mouseenter", _this.contPrevNext + " " + _this.contNext, _this.prevProduct);
	};
	window.msDetailProduct.prototype.counter = function(_this) {
		if (_this.SITE_ID == "" || _this.PRODUCT_ID == "") return false;
		path = '/bitrix/components/bitrix/catalog.element/ajax.php';
		params = {
			AJAX: 'Y',
			SITE_ID: _this.SITE_ID,
			PRODUCT_ID: _this.PRODUCT_ID,
			PARENT_ID: 0
		};
		BX.ajax.post(path, params, function(data) {});
	};
	window.msDetailProduct.prototype.clickAddBasket = function(e)
	{
		e.preventDefault();
		_this = e.data;
		if (!_this.checkProps($(_this.add_url))) return false;
		url = _this.basket_url[_this.offerID];
		quan = $(_this.quantityInput).val();
		if (typeof quan != "undefined") url += "&quantity=" + quan;
		BX.ajax.loadJSON(url, "", _this.successBasket);
	};
	window.msDetailProduct.prototype.successBasket = function(data)
	{
		if (data.STATUS == "OK")
		{
			changeButton(_this.btn_basket,BX.message("MS_JS_CATALOG_ADDED_BASKET"),_this.basketPath, _this.btn_class, _this.btn_change_class);
			_this.added_to_basket[_this.offerID] = 1;
			BX.onCustomEvent('OnBasketChange');
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			if (_this.isMobile)
			{
				_this.afterAddBasketMobile();
			}
			else
			{
				_this.afterAddBasket();
			}
		}
		else alert(data.MESSAGE);
	};
	window.msDetailProduct.prototype.afterAddBasket = function() {
		_this = this;
		if ($('.gift-product-wrapper').length) {
			/*$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
				scrollTop: $(".gift-product-wrapper").offset().top
			}, 1000, function() {
				BX.onCustomEvent('OnBasketChange');
			});*/
		} else {
			/*$("html:not(:animated)" + (!$.browser.opera ? ",body:not(:animated)" : "")).animate({
				scrollTop: 0
			}, 1000, function() {
				BX.onCustomEvent('OnBasketChange');
			});*/
		}
	};
	window.msDetailProduct.prototype.afterAddBasketMobile = function() {
		_this = this;
		BX.onCustomEvent('OnBasketChange');
	};
	window.msDetailProduct.prototype.clickAddWish = function(e) {
		e.preventDefault();
		_this = e.data;
		if (!_this.checkProps($(_this.add_wish))) return false;
		url = _this.wish_url[_this.offerID];
		// BX.ajax.loadJSON('/include/ajax/basket_add_product_and_wish.php?ajax_basket=Y&action=add&entity=delay&s_id='+_this.offerID, "", _this.successWish);
		BX.ajax.loadJSON(url, "", _this.successWish);
	};
	window.msDetailProduct.prototype.successWish = function(data)
	{
		if (data.STATUS == "OK")
		{
			_this.boolLoadBasket = false;
			_this.boolScrollBasket = false;
			OpenModal(_this.modalUrl, _this.modalData, 'add_wish');
		}
		else
		{
			alert(data.MESSAGE);
		}
	};
	window.msDetailProduct.prototype.afterSuccesBasket = function(data) {
		_this.boolLoadBasket = true;
		if (data == "") return false;
		$(_this.contBasket).children().remove();
		$(_this.contBasket).unbind("mouseleave");
		var h_basket = $(_this.contBasket).innerHeight() + "px";
		$(".window_basket").css("top", h_basket);
		$(_this.contBasket + " .window_basket").hide();
		if (_this.boolScrollBasket) {
			$(_this.contBasket + " .window_basket").slideDown(1000, _this.scrollSlideEnd);
		}
	};
	window.msDetailProduct.prototype.checkProps = function(cont_modal) {
		_this = this;
		if (_this.offerID <= 0) {
			bool = true;
			$(_this.ul).each(function() {
				if ($(this).find(_this.classLiActive).length == 0) {
					bool = false;
				}
			})
			if (!bool) {
				return false;
			}
		}
		return true;
	};
	window.msDetailProduct.prototype.clickProp = function(e) {
		_this = e.data;

		if ($(this).is(_this.classLiDesabled)) return false;

		if ($(this).is(_this.classLiAvailable)) {
			$(_this.availableContainer).show();
			$(_this.priceContainer).hide();
		} else {
			$(_this.priceContainer).show();
			$(_this.availableContainer).hide();
		}

		if(e.isTrigger)
		{
			xmlID = $(_this.propColor).find('.li-active').attr("data-xml");
		}
		else
		{
			xmlID = $(this).attr("data-xml");
		}


		_this.currentLi = $(this);
		_this.parent = $(this).parents(_this.ul).eq(0);
		_this.currentUl = $(_this.ul).index(_this.parent);
		$(_this.parent).each(function(i, v) {
			$(this).find('.li-active').removeClass('li-active')
		});
		$(this).addClass('li-active');
		_this.calculate();
		_this.calculateAvailable();
		_this.calculateID();

		_this.imgprop = false;
		if(_this.arImage2need.length > 0)
		{
			$(_this.arImage2need).each(function(i, v)
			{
				if(_this.parent.is('.detail_page_wrap.no_preview #offer_prop_'+v))
				{
					_this.imgprop = true;
				}
			});
		}

		if (_this.parent.is(_this.propColor) || _this.imgprop || e.isTrigger)
		{
			_this.createImage();
		}
		_this.calculateAvailableBlock();
		_this.calculatePrice();
		_this.offerProps();

		return false;
	};
	window.msDetailProduct.prototype.calculate = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		$(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).each(function() {
					$(this).removeClass("li-disable");
					arOfferAttr = $(this).attr("data-offer").split(",");
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-disable");
						$(this).removeClass("li-active");
						$(this).removeClass("li-available");
					}
				})
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msDetailProduct.prototype.calculateAvailable = function() {
		_this = this;
		var arVarPrev = new Array();
		var erEmpty = new Array();
		var arVarCur = new Array();
		offerAvailable = _this.offerAvailable;
		$(_this.ul).each(function(i, v) {
			if (typeof arVarPrev != "undefined" && arVarPrev.length > 0) {
				$(this).find(_this.li).not(".li-disable").each(function() {
					$(this).removeClass("li-available");
					arOfferAttr = $(this).attr("data-offer").split(",");
					arOfferAttr = arOfferAttr.filter(function(n) {
						if (typeof offerAvailable[n] == "undefined") return true;
						else return false;
					});
					erEmpty = arVarPrev.filter(function(n) {
						return arOfferAttr.indexOf(n) !== -1;
					});
					if (erEmpty.length == 0) {
						$(this).addClass("li-available");
					}
				});
				AllCnt = $(this).find(_this.li).length;
				OtherCnt = $(this).find(_this.li).not(".li-active").length;
				if (AllCnt - OtherCnt == 0)
				{
					_this.propTrigger = 1;
					$(this).find(_this.li).not(".li-disable").first().trigger('click',{'xmlID':xmlID});
					return false;
				}
			}
			if (typeof $(this).find(_this.classLiActive).eq(0).attr("data-offer") == "undefined") {} else {
				arVarCur = $(this).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
			}
			if (typeof arVarPrev == "undefined" || arVarPrev.length == 0) {
				arVarPrev = arVarCur;
			} else {
				arVarPrev = arVarPrev.filter(function(n) {
					return arVarCur.indexOf(n) !== -1;
				});
			}
		})
	};
	window.msDetailProduct.prototype.calculateID = function() {
		_this = this;
		arOffer = $(_this.ul).eq(0).find(_this.classLiActive).eq(0).attr("data-offer").split(",");
		countUl = $(_this.ul).length;
		countLi = $(_this.ul).find(_this.classLiActive).length;
		if (countUl != countLi) {
			_this.offerID = 0;
			return false;
		}

		$(_this.ul).each(function() {
			_this.offerID = 0;
			$(this).find(_this.classLiActive).each(function() {
				arAttrOffer = $(this).attr("data-offer").split(",");
				$.each(arOffer, function(i, v) {
					if ($.inArray(v, arAttrOffer) == -1) delete arOffer[i];
					else _this.offerID = v;
				})
			});
			$(_this.main + " [name=PRODUCT_ID]").val(_this.offerID);
		});

		BX.onCustomEvent('onCatalogStoreProductChange', [_this.offerID]);
	};
	window.msDetailProduct.prototype.calculateAvailableBlock = function()
	{
		_this = this;
		if (_this.offerID && typeof _this.offerID != "undefined")
		{
			offerAvailable = _this.offerAvailable;
			if (typeof offerAvailable[_this.offerID] != "undefined")
			{
				$('#subscribe').attr('data-item', _this.offerID);
				$('.subscribe_new .subscribe_new_form input[name="itemId"]').attr('value', _this.offerID);
				$(_this.availableContainer).show();
				$(_this.priceContainer).hide();
			}
			else
			{
				$(_this.availableContainer).hide();
				$(_this.priceContainer).show();
				if(typeof _this.added_to_basket[_this.offerID] !== undefined)
				{
					if(_this.added_to_basket[_this.offerID] == 0)
					{
						if($(_this.btn_basket).hasClass(_this.btn_change_class))
						{
							changeButton(_this.btn_basket,BX.message("B2BS_CATALOG_DETAIL_IN_CART"),'',_this.btn_class, _this.btn_change_class);
						}
					}
					else
					{
						if($(_this.btn_basket).hasClass(_this.btn_class))
						{
							changeButton(_this.btn_basket,BX.message("MS_JS_CATALOG_ADDED_BASKET"),_this.basketPath, _this.btn_class, _this.btn_change_class);
						}
					}
				}
			}
		}
	};
	window.msDetailProduct.prototype.calculatePrice = function()
	{
		if (this.offerID > 0 && this.prices[this.offerID])
		{
			$(this.main + " " + this.discountPrice).text(this.prices[this.offerID]["DISCOUNT_PRICE"]);
			if (this.prices[this.offerID]["DISCOUNT_PRICE"] != this.prices[this.offerID]["OLD_PRICE"])
			{
				$(this.main + " " + this.oldPrice).text(this.prices[this.offerID]["OLD_PRICE"]);
			}
			else
			{
				$(this.main + " " + this.oldPrice).text('');
			}
		}
	};
	window.msDetailProduct.prototype.calculateButton = function()
	{
		if (this.offerID > 0)
		{

		}
	};
	window.msDetailProduct.prototype.createImage = function()
	{
			_this = this;
			zoomStr = "";
			zoomSlideStr = "";
			zoomStr += '<div class="detail_big_pic">';
			bool = true;


			$.each(_this.arVideo, function(i, v) {
				zoomStr += '<div class="detail_big_video" style="position:absolute;display:none;width: 100%;height: 100%;">' + v + '</div>';
			});

			if(_this.imgprop)
			{
				$.each(_this.arImage2[_this.offerID]["MEDIUM"], function(i, v) {

					src = v["src"];
					width = v["width"];
					height = v["height"];
					bigSrc = _this.arImage2[_this.offerID]["BIG"][i]["src"];
					if (bool) strBool = "block";
					else strBool = "none";
					zoomStr += '<a class="big_foto item" href="' + bigSrc + '" onclick="return false;" alt="" title="" style="display:' + strBool + '"><img width="' + width + '" height="' + height + '" alt="" title="" src="' + src + '" class="img-responsive"></a>';
					bool = false;
				});
			}
			else
			{
				$.each(_this.arImage[xmlID]["MEDIUM"], function(i, v) {
					src = v["src"];
					width = v["width"];
					height = v["height"];
					bigSrc = _this.arImage[xmlID]["BIG"][i]["src"];
					if (bool) strBool = "block";
					else strBool = "none";
					zoomStr += '<a class="big_foto item" href="' + bigSrc + '" onclick="return false;" alt="" title="" style="display:' + strBool + '"><img width="' + width + '" height="' + height + '" alt="" title="" src="' + src + '" class="img-responsive"></a>';
					bool = false;
				});
			}


			if (_this.download == "Y") zoomStr += '<a class="download_pic" href="#"  onclick="download_img(this);" target="_blank"></a>';
			zoomStr += '</div>';
			bool = true;
			var CntImages = 0;
			$.each(_this.arVideo, function(i, v) {
				CntImages += 1;
				zoomSlideStr += '<div class="item-video"><img class="img-responsive PlayVideoProduct" src="' + _this.TemplatePath + '/site_files/img/miss_video-play.jpg" width="" height="" data-key="' + i + '"/></div>';
			});

			if(_this.imgprop)
			{
				$.each(_this.arImage2[_this.offerID]["SMALL"], function(i, v) {
					src = v["src"];
					width = v["width"];
					height = v["height"];
					mediumSrc = _this.arImage2[_this.offerID]["MEDIUM"][i]["src"];
					bigSrc = _this.arImage2[_this.offerID]["BIG"][i]["src"];
					if (bool) strBool = "item_active";
					else strBool = "";
					if (_this.Wrapper == '.preview') {
						zoomSlideStr += '<a class="item fancybox_little_img_preview' + _this.PRODUCT_ID + ' ' + strBool + '" rel="gallery_preview" onclick=""';
					} else {
						zoomSlideStr += '<a class="item fancybox_little_img ' + strBool + '" rel="gallery_no_preview"';
					}
					zoomSlideStr += ' href="' + bigSrc + '"><img width="' + width + '" height="' + height + '" alt="" title="" src="' + src + '" class="img-responsive"></a>';
					bool = false;
					CntImages += 1;
				});
			}
			else
			{
				$.each(_this.arImage[xmlID]["SMALL"], function(i, v) {
					src = v["src"];
					width = v["width"];
					height = v["height"];
					mediumSrc = _this.arImage[xmlID]["MEDIUM"][i]["src"];
					bigSrc = _this.arImage[xmlID]["BIG"][i]["src"];
					if (bool) strBool = "item_active";
					else strBool = "";
					if (_this.Wrapper == '.preview') {
						zoomSlideStr += '<a class="item fancybox_little_img_preview' + _this.PRODUCT_ID + ' ' + strBool + '" rel="gallery_preview" onclick=""';
					} else {
						zoomSlideStr += '<a class="item fancybox_little_img ' + strBool + '" rel="gallery_no_preview"';
					}
					zoomSlideStr += ' href="' + bigSrc + '"><img width="' + width + '" height="' + height + '" alt="" title="" src="' + src + '" class="img-responsive"></a>';
					bool = false;
					CntImages += 1;
				});
			}
			if (zoomSlideStr != "" && CntImages > 1) {
				zoomStr += '<div class="wrap_detail_pic_small"><div class="js_slider_pic_small  detail_pic_small">' + zoomSlideStr + '</div></div>';
			}
			$(_this.imgContainer).html(zoomStr);
			if (_this.Wrapper == '.preview') {
				zoom_quick_view_img('.wrap_quick_view_js');
			} else {
				zoom_detail_img();
			}



			if(_this.arImage2need.length > 0)
			{
				var fl = $('.detail_color1 .li-active').attr("data-offer").split(",");
				$.each($('.detail_color2 li'),function(i,v){
					arAttrOffer = $(this).attr("data-offer").split(",");

					var inter = intersect(fl, arAttrOffer);
					if(inter.length > 0)
					{
						$(this).find('img').attr({
							'src':_this.arImage2[inter[0]]['SMALL'][0]['src'],
						});
					}
					else
					{
						$(this).find('img').attr({'src':'/upload/no_photo.jpg'});
					}
				});
			}



		}
	window.msDetailProduct.prototype.offerProps = function() {
		_this = this;
		for (var code in _this.OffersProps[_this.offerID]) {
			if (_this.OffersProps[_this.offerID][code] == "") {
				$('.offer-props [data-prop="' + code + '"]').parent().hide();
			} else {
				$('.offer-props [data-prop="' + code + '"]').html(_this.OffersProps[_this.offerID][code]);
				$('.offer-props [data-prop="' + code + '"]').parent().show();
			}
		}
	};
})(window, document, jQuery);
/////SUBSCRIBE//////
(function(window, document, $, undefined) {
	window.msSubcribeProduct = function(arParams) {
		this.SubscribeIdHidden = "";
		this.SubscribeNoAuth = "";
		this.AlreadySubscribe = "";
		this.WrapSubscribe = "";
		this.SubscribeProductForm = "";
		this.SubscribeProductEmailForm = "";
		this.SubscribeProductEmailFormWrapper = "";
		this.SubscribeProductEmailFormSubmit = "";
		this.SubscribeProductEmail = "";
		this.this_ = this;
		if ('object' === typeof arParams) {
			this.SubscribeIdHidden = arParams.SubscribeIdHidden;
			this.SubscribeNoAuth = arParams.SubscribeNoAuth;
			this.AlreadySubscribe = arParams.AlreadySubscribe;
			this.WrapSubscribe = arParams.WrapSubscribe;
			this.SubscribeProductForm = arParams.SubscribeProductForm;
			this.SubscribeProductEmailForm = arParams.SubscribeProductEmailForm;
			this.SubscribeProductEmailFormWrapper = arParams.SubscribeProductEmailFormWrapper;
			this.SubscribeProductEmailFormSubmit = arParams.SubscribeProductEmailFormSubmit;
			this.SubscribeProductEmail = arParams.SubscribeProductEmail;
		}
		this.destroy(this);
		this.init(this);
	};
	window.msSubcribeProduct.prototype.init = function(_this) {
		var ProductId = $(_this.SubscribeIdHidden).data('item');
		CheckSubscribe(ProductId, _this);
		$(document).on("click", _this.SubscribeIdHidden, _this, _this.clickSubscribeIdHidden);
		$(document).on("click", _this.SubscribeNoAuth, _this, _this.clickSubscribeNoAuth);
		$(document).on("click", _this.SubscribeProductEmailFormSubmit, _this, _this.clickSubscribeProductEmailFormSubmit);
	};
	window.msSubcribeProduct.prototype.destroy = function() {};
	window.msSubcribeProduct.prototype.clickSubscribeIdHidden = function(e) {
		e.preventDefault();
		_this = e.data;
		var ProductId = $(this).data('item');
		CheckSubscribe(ProductId, _this);
	};
	window.msSubcribeProduct.prototype.clickSubscribeNoAuth = function(e) {
		e.preventDefault();
		_this = e.data;
		var this_ = _this;
		var this__ = this;
		var ProductId = $(this).closest(this_.WrapSubscribe).find(_this.SubscribeIdHidden).data('item');
		BX.ajax({
			method: 'POST',
			dataType: 'json',
			url: '/bitrix/components/bitrix/catalog.product.subscribe/ajax.php',
			data: {
				sessid: BX.bitrix_sessid(),
				subscribe: 'Y',
				itemId: ProductId,
				siteId: BX.message('SITE_ID')
			},
			onsuccess: BX.delegate(function(result) {
				if (result.success) {
					$(this_.SubscribeNoAuth).msTooltip({
						"class": "class_subscribe",
						"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
						"is_hover": false,
						"timeOut": false
					});
					$(this__).closest(this_.WrapSubscribe).find(this_.SubscribeProductForm).hide();
					$(this__).closest(this_.WrapSubscribe).find(this_.AlreadySubscribe).show();
				}
			})
		});
	};
	window.msSubcribeProduct.prototype.clickSubscribeProductEmailFormSubmit = function(e) {
		e.preventDefault();
		_this = e.data;
		var this__ = this;
		var this_ = _this;
		var FormData = $(_this.SubscribeProductEmailForm).serialize();
		BX.ajax.post('/bitrix/components/bitrix/catalog.product.subscribe/ajax.php', FormData, function(resultForm) {
			resultForm = BX.parseJSON(resultForm, {});
			if (resultForm.success) {
				$(this__).closest(this_.WrapSubscribe).find(this_.SubscribeProductEmail).msTooltip({
					"class": "class_subscribe",
					"message": BX.message("MS_JS_CATALOG_ADD_SUBSCRIBE"),
					"is_hover": false,
					"timeOut": false
				});
				$(this__).closest(this_.WrapSubscribe).find(this_.AlreadySubscribe).show();
				$(this__).closest(this_.WrapSubscribe).find(this_.SubscribeProductEmail).hide();
			} else if (resultForm.error) {
				if (resultForm.hasOwnProperty('setButton')) {
					this.listOldItemId[this.elemButtonSubscribe.dataset.item] = true;
					this.setButton(true);
				}
				var errorMessage = resultForm.message;
				if (resultForm.hasOwnProperty('typeName')) {
					errorMessage = resultForm.message.replace('USER_CONTACT', resultForm.typeName);
				}
				$(this__).closest(this_.WrapSubscribe).find('.error').html(errorMessage).show();
			}
		});
	};
})(window, document, jQuery);

function CheckSubscribe(ProductId, _this)
{
	var this_ = _this;
	BX.ajax({
		method: 'POST',
		dataType: 'json',
		url: '/bitrix/components/bitrix/catalog.product.subscribe/ajax.php',
		data: {
			sessid: BX.bitrix_sessid(),
			checkSubscribe: 'Y',
			itemId: ProductId
		},
		onsuccess: BX.delegate(function(result) {
			if (result.subscribe) // if already subcribe
			{
				$(this_.SubscribeProductForm).hide();
				$(this_.SubscribeProductEmail).hide();
				$(this_.AlreadySubscribe).show();
			} else {
				//$(this_.SubscribeProductForm).show();
				$(this_.AlreadySubscribe).hide();
			}
		}, this)
	});
}
if (window.frameCacheVars !== undefined)
{
	BX.addCustomEvent("onFrameDataReceived", function(json) {
		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		LazyLoad();
		TopAllBrands(isMobile);
		MainBanner();
		BlockBrand();
		MainPageNews();
		height_catalog_row();
		height_catalog_title();
		OnlineBuyers();
		resizeOwl();
		changeWidgetWidth();
		loadSliderViewedProductsElement();
		if ($('.icon_property_wrap').length)
		{
			icon_position('.icon_property_wrap');
		}
	});
}
else
{
	BX.ready(function() {
		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		LazyLoad();
		height_catalog_row();
		height_catalog_title();
		TopAllBrands(isMobile);
		MainBanner();
		BlockBrand();
		MainPageNews();
		OnlineBuyers();
		resizeOwl();
		changeWidgetWidth();
		loadSliderViewedProductsElement();
		if ($('.icon_property_wrap').length)
		{
			icon_position('.icon_property_wrap');
		}
	});
}

function TopAllBrands(isMobile)
{
	if (isMobile && $(".dsqv").length > 0) {
		$(".dsqv").removeAttr("class");
	}
	if ($("#main-top-menu").length) {
		$("#main-top-menu").mainMenu();
	}
	$('#toggle_alpha').click(function() {
		toggle_alpha();
		return false;
	});
	if (!isMobile) {
		$('.main-top-center > li > span').mouseenter(function() {
			var this_ = $(this).parent('li');
			var timerId_alpha = setTimeout(function() {
				toggle_alpha_inner(this_, isMobile);
			}, 500);
			$(this).mouseleave(function() {
				clearTimeout(timerId_alpha);
			});
		});
	} else {
		$('.main-top-center > li > span').click(function() {
			var this_ = $(this).parent('li');
			toggle_alpha_inner(this_, isMobile);
		});
	}
}

function MainBanner()
{
	if ($("#main-banner").length)
	{
		VideoWidth = $("#main-banner").attr('data-width');
		VideoHeight = $("#main-banner").attr('data-height');
		VideoResponceWidth = $("#main-banner").width();
		VideoResponceHeight = Math.round(parseInt(VideoHeight) / (parseInt(VideoWidth) / parseInt(VideoResponceWidth)));
		$("#main-banner video").attr('width', VideoResponceWidth);
		$("#main-banner video").attr('height', VideoResponceHeight);
		if ($("#main-banner").children().length > 1)
		{
			$("#main-banner").owlCarousel({
				autoplay: true,
				autoplayTimeout: 5000,
				autoplayHoverPause: true,
				nav: true,
				loop: true,
				items: 1,
				navText: ["", ""],
				dots: true,
				video: true,
				videoWidth: VideoResponceWidth,
				videoHeight: VideoResponceHeight,
				smartSpeed: 800,
				onTranslated: function() {
					var attr = $("#main-banner .active").attr('data-video');
					if (attr !== undefined && attr !== false) {
						$("#main-banner .owl-dots").hide();
					} else {
						$("#main-banner .owl-dots").show();
					}
				},
				onInitialized: function() {
					var attr = $("#main-banner .active").attr('data-video');
					if (attr !== undefined && attr !== false) {
						$("#main-banner .owl-dots").hide();
					} else {
						$("#main-banner .owl-dots").show();
					}
				}
			});
		}
		$("#main-banner .item.item_absolute").removeClass("item_absolute");
	}
}

function BlockBrand()
{
	if ($('#block_brand').length)
	{
		$("#block_brand .block_carousel").owlCarousel({
			nav: true,
			smartSpeed: 400,
			dots: false,
			navText: ["", ""],
			items: 5,
			loop: false,
			responsive: {
				0: {
					items: 2
				},
				768: {
					items: 3
				},
				979: {
					items: 4
				},
				1199: {
					items: 4
				}
			}
		});
	}
}

function MainPageNews()
{
	if ($('.bl_right').length) {
		if ($('.bl_right ul li').length > 1) {
			$(".news_slide ul").owlCarousel({
				items: 1,
				dots: true,
				navText: ["", ""],
				loop: true,
				smartSpeed: 1000,
				animateIn: 'fadeIn',
				animateOut: 'fadeOut',
				loop: true,
				autoplay: true,
				autoplayTimeout: 7000,
				autoplayHoverPause: true,
			});
		} else {
			$(".news_slide ul").owlCarousel({
				items: 1,
				dots: true,
				navText: ["", ""],
				smartSpeed: 1000,
				animateIn: 'fadeIn',
				animateOut: 'fadeOut',
				autoplay: true,
				autoplayTimeout: 7000,
				autoplayHoverPause: true,
			});
		}
		$(".news_slide .item.item_absolute").removeClass("item_absolute");
	}
}

function OnlineBuyers()
{
	if ($("#buy-now-slider").length) {
		$('#buy-now-slider').css({
			'width': '100%'
		});
		$('#buy-now-slider .item').css({
			'float': 'none'
		});
		$("#buy-now-slider").owlCarousel({
			nav: true,
			smartSpeed: 400,
			dots: false,
			navText: ["", ""],
			responsive: {
				0: {
					items: 2
				},
				768: {
					items: 3
				},
				1199: {
					items: 4
				}
			},
			onChanged: function() {
				if($('.b-lazy').length)
				{
					var bLazy = new Blazy({
						selector: '.b-lazy',
						loadInvisible: 'true',
						success: function(image) {
							var element = $(image);
							if (element.parent().attr('class') == 'b-lazy-wrapper') {
								element.unwrap();
							}
						}
					});
					bLazy.revalidate();
				}
			}
		});
	}
}

/**
 * modal form
 * @param openUrl
 * @param data json
 * @param classModal
 * @returns
 */
function OpenModal(openUrl, data, classModal) {
	BX.ajax({
		url: openUrl,
		method: 'POST',
		dataType: 'html',
		data: {'data':data},
		onsuccess: function(data)
		{//console.log(data);
			modal_windows_show(data, classModal);
		},
	});
}



/////GIFTS/////
function bx_sale_gift_product_load(injectId, localAjaxData, additionalData) {
	localAjaxData = localAjaxData || {};
	additionalData = additionalData || {};
	BX.ajax({
		url: '/bitrix/components/bitrix/sale.gift.product/ajax.php',
		method: 'POST',
		data: BX.merge(localAjaxData, additionalData),
		dataType: 'html',
		processData: false,
		start: true,
		onsuccess: function(html) {
			var ob = BX.processHTML(html);
			BX(injectId).innerHTML = ob.HTML;
			BX.ajax.processScripts(ob.SCRIPT);
		}
	});
};

function loadSliderViewedProductsElement()
{
	if ($('.js_slider_6').length) {
		$('.js_slider_6').css({
			'width': '100%'
		});
		$('.js_slider_6 .item').css({
			'float': 'none'
		});
		$(".js_slider_6").owlCarousel({
			nav: true,
			smartSpeed: 400,
			dots: false,
			navText: ["", ""],
			items: 6,
			loop: true,
			responsive: {
				0: {
					items: 2
				},
				768: {
					items: 3
				},
				979: {
					items: 4
				},
				1199: {
					items: 6
				}
			}
		});
	}
}

$(document).ready( function()
{
	$(".file-upload input[type=file]").change(function(){
		var filename = $(this).val().replace(/.*\\/, "");
		$("#filename").val(filename);
	});
});

function changeButton(button, message, basketUrl,btnClass,btnChangeClass)
{
	var buttonObj = $(button);
	if(buttonObj.hasClass(btnChangeClass))
	{
		buttonObj.removeClass(btnChangeClass);
		buttonObj.addClass(btnClass);
	}
	else
	{
		buttonObj.addClass(btnChangeClass);
		buttonObj.removeClass(btnClass);
	}
	if(basketUrl != '' && typeof basketUrl === 'string')
	{
		buttonObj.html('<a href="' + basketUrl +'">' + message + '</a>');
	}
	else
	{
		buttonObj.html(message);
	}
}

//////LOGIN MODAL////////
function OpenModalLogin(RegisterUrl, ForgotPasswordUrl, openUrl) {
	var class_ = 'login_enter';
	BX.ajax({
		url: openUrl,
		method: 'POST',
		dataType: 'html',
		data: 'backurl=' + window.location.href + "&register_url=" + RegisterUrl + "&forgot_password=" + ForgotPasswordUrl + "&open_login=yes",
		onsuccess: function(data) {
			modal_windows_show(data, class_);
		},
	});
}



/* START --- RESIZE PERSONAL (LEFT MENU) */

$(document).ready(function() {

	$(document).on("click", ".blank_resizer_tool", function()
	{
		if(!$('.blank_resizer_tool').hasClass('blank_resizer_tool_open'))
		{
			$('.blank_left_side').hide();
			$('.blank_resizer_tool').addClass('blank_resizer_tool_open');
			$('.blank_right-side').addClass('blank_right-side_full');
			var heightCenterWrap = parseInt($('.inner_page .center_wrap').css('min-height'));
			$('#wrapper_blank_resizer').css({'min-height':heightCenterWrap});
			changeWidgetWidth();
			calcLeftPersonalMenuTool();
			$.ajax({
				type: 'POST',
				url:SITE_DIR + 'include/ajax/blank_side.php',
				data: {Open:'N'},
				success: function(data){},
				error:  function (jqXHR, exception) {}
			});
		}
	});

	$(document).on("click", ".blank_resizer_tool_open", function()
	{
		$('.blank_right-side').removeClass('blank_right-side_full');

		$('.blank_left_side').show();

		$('.blank_resizer_tool').removeClass('blank_resizer_tool_open');

		var heightLeftSide = $('.blank_left_side .personal_left_wrap').height();
		$('#wrapper_blank_resizer').css({'min-height':heightLeftSide});
		changeWidgetWidth();
		calcLeftPersonalMenuTool();
		$.ajax({
			type: 'POST',
			url: SITE_DIR + 'include/ajax/blank_side.php',
			data: {Open:'Y'},
			success: function(data){},
			error:  function (jqXHR, exception) {}
		});
	});
});

$(function()
{
	if($("div").is("#wrapper_blank_resizer"))
	{

		leftMenuOneHeight();
		var resizedPos = $('#wrapper_blank_resizer').offset();
		var resizedToolPos = $('.blank_resizer_tool').offset();
        var w = $(window);

		$('.blank_resizer_tool').css({'top':resizedPos.top, 'margin-top':'0'});

		var isMobile = navigator.userAgent.match(/iPhone|iPad|iPod|Android|IEMobile/i);
		if(!isMobile)
		{
			resizedToolPos.left = resizedToolPos.left + 4;
			// $('.blank_resizer_tool').css({'left':resizedToolPos.left});
		}

		if(!$('.border-profile-personal .blank_resizer_tool').length)
		{
			$('.blank_resizer_tool').css({'opacity':'1'});
		}

		$(window).scroll(function()
		{
			var top = $(document).scrollTop();
            var w = $(window);

			var resizedHeight = $('#wrapper_blank_resizer').height();
			var resizedToolPos = $('.blank_resizer_tool').offset();

			var topBlock = top + $(window).height()/2 - resizedPos.top - $('.blank_resizer_tool').height();
			// var topBlock = top - (resizedToolPos.top - $(window).height())/2;

			if(topBlock < 0)
				topBlock = 0;

			if(topBlock > resizedHeight - $('.blank_resizer_tool').height())
				topBlock = resizedHeight - $('.blank_resizer_tool').height();

            $('.blank_resizer_tool').css({'top' : topBlock});
			// if(resizedPos.top + resizedHeight - $('.blank_resizer_tool').height() < resizedToolPos.top)
			// {
			// 	$('.blank_resizer_tool').css({'top':resizedPos.top + resizedHeight - $('.blank_resizer_tool').height() - top});
			// }
            //
			// if(resizedPos.top > resizedToolPos.top)
			// {
			// 	$('.blank_resizer_tool').css({'top':resizedPos.top});
			// }
		});
	}
});

/* END --- RESIZE PERSONAL (LEFT MENU) */



/*-------widgets--------*/

$(window).bind("resize", function()
{
	leftMenuOneHeight();
});
$(window).bind("orientationchange", function()
{
	leftMenuOneHeight();
});

function changeWidgetWidth()
{
	if (parseInt(window.innerWidth) > 767)
	{
		$('.gd-page-column2').css({'margin-top': '0px'});
		if ($('.blank_right-side_full').length)
		{
			$('.gd-page-column').outerWidth('33%');
		}
		else
		{
			leftMenuOneHeight();
			$('.gd-page-column').outerWidth('50%');
			var razn = $('.gd-page-column1').outerHeight() - $('.gd-page-column0').outerHeight();
			if(razn > 10)
			{
				$('.gd-page-column2').css({'margin-top': '-'+razn  +'px'});
			}
		}
	}
}


function leftMenuOneHeight()
{
	if (parseInt(window.innerWidth) > 768)
	{
		$('#wrapper_blank_resizer').css({'min-height':'unset'});
		$('#blank_left_side .personal_left_wrap').css({'min-height':'unset'});
		var heightLeftSide = parseInt($('.blank_left_side .personal_left_wrap').outerHeight());
		var heightCenterWrap = parseInt($('.wrapper_blank_resizer').outerHeight());
		if(heightLeftSide <= 0)
		{
			heightLeftSide = 510;
		}
		if(heightLeftSide > heightCenterWrap)
		{
			heightLeftSide+=10;
			$('#wrapper_blank_resizer').css({'min-height':heightLeftSide});
			$('#blank_left_side .personal_left_wrap').css({'min-height':heightLeftSide});
		}
		else
		{
			if($('.border-profile-blank').length > 0)
			{
				heightCenterWrap += 162;
			}
			$('#wrapper_blank_resizer').css({'min-height':heightCenterWrap});
			$('#blank_left_side .personal_left_wrap').css({'min-height':heightCenterWrap});
		}
	}
}


function calcLeftPersonalMenuTool()
{
	var resizedPos = $('.wrapper_blank_resizer').offset();
	var top = $(document).scrollTop();

	//$('.blank_resizer_tool').css({'left':resizedPos.left - 16});

	var resizedHeight = $('#wrapper_blank_resizer').height();
	var resizedToolPos = $('.blank_resizer_tool').offset();

	/*if(resizedPos.top + resizedHeight - $('.blank_resizer_tool').height() < resizedToolPos.top)
	{
		$('.blank_resizer_tool').css({'top':resizedPos.top + resizedHeight - $('.blank_resizer_tool').height() - top});
	}

	if(resizedPos.top > resizedToolPos.top)
	{
		$('.blank_resizer_tool').css({'top':resizedPos.top});
	}*/


	if($('.border-profile-blank').length > 0)
	{
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
}
/*---------------------*/
$(document).ready(function() {
	$('input[name=quantity]').bind("change keyup input click", function () {
		if (this.value.match(/[^0-9]/g)) {
			this.value = this.value.replace(/[^0-9]/g, '');
		}
	});
});


function intersect(a, b) {
	var t;
	if (b.length > a.length) t = b, b = a, a = t;
	return a.filter(function (e) {
		return b.indexOf(e) > -1;
	});
}