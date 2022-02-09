(function( $ ) {
	$.fn.msCalculateBasketOrder = function(options) {
		var containerMain = "";
		var contProps = "";
		var contItemProps = "";
		var contItemActive = "";
		
		var attrItemProps = "";
		var attrItemID = "";
		var attrItemProperty = "";
		var itemActive = "";
		var nameProps = "";
		var nameMainVar = "";
		var basketItemId = 0;
		var offerID = 0;
		var basketUrl = "";
		var _this = "";
		
		var methods = {
			calculate : function(){
				$(document).on("submit",'#basket_form',function(e){
					setTimeout(function(){BX.closeWait();},700);
				});
				$(document).on("click", containerMain+" "+contProps+" "+contItemProps, function(e){ 
					if($(this).is(".li-disable")) return false;
					_this = $(this); 
					mainParent = $(this).parents(containerMain).eq(0);
					parent = $(this).parents(contProps).eq(0);
					currentUl = mainParent.find(contProps).index(parent);
					arOffer = mainParent.find(contProps).eq(0).find(contItemActive).eq(0).attr("data-offer").split(",");
					offerID = 0;
					var arVarPrev = new Array();
					var erEmpty = new Array();
					mainParent.find(contProps).each(function(i, v){
						if(typeof arVarPrev !="undefined" && arVarPrev.length>0)
						{
							$(this).find(contItemProps).each(function(){
								$(this).removeClass("li-disable");
								arOfferAttr = $(this).attr("data-offer").split(",");
								erEmpty = arVarPrev.filter(function(n) {
									return arOfferAttr.indexOf(n) !== -1;
								});
								
								if(erEmpty.length==0)
								{
									$(this).addClass("li-disable");
									$(this).removeClass("li-active");
								}
							})	
						}
						
						if(typeof $(this).find(contItemActive).eq(0).attr("data-offer")=="undefined")
						{
								
						}else{
							arVarCur = $(this).find(contItemActive).eq(0).attr("data-offer").split(",");	
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
					
					mainParent.find(contProps).each(function(i, v){
						offerID = 0;
						if($(this).find(contItemActive).length>0)
						{
							$(this).find(contItemActive).each(function(){
								arAttrOffer = $(this).attr("data-offer").split(",");
						   
								$.each(arOffer, function(i, v){
									if($.inArray(v, arAttrOffer)==-1) delete arOffer[i];
									else offerID = v;
								})

							});	
						}else{
							offerID = 0;
							return false;	
						}
						
						
					})
					if(offerID>0)
					{
						methods.sendQuery();
					}
				})
			},
			sendQuery : function(){
				if(_this)
				{
					container = _this.parents(containerMain).eq(0); 
					basketItemId = _this.attr(attrItemID); 
					ajaxID = _this.attr("data-ajax");
					entity = _this.attr("data-entity");
					getUrl = "?"+nameMainVar+"=Y&ajax_basket=Y&action=calculate&entity="+entity+"&s_id="+basketItemId+"&bxajaxid="+ajaxID;
					strProps = "";
					container.find(contProps+" "+contItemProps+itemActive).each(function(){
						prop = $(this).attr(attrItemProperty);
						val = $(this).attr(attrItemProps);
						strProps += prop+",";
						getUrl += "&"+nameProps+"["+prop+"]="+val;	
					})
					basketUrl = '/include/ajax/basket_add_product_and_wish.php';
					BX.ajax.insertToNode(basketUrl+getUrl+"&props="+strProps+"&offerID="+offerID, 'comp_'+ajaxID);
				}else{
					ajaxID = $(containerMain+" "+contProps+" "+contItemProps).eq(0).attr("data-ajax");
					getUrl = "?"+nameMainVar+"=Y&bxajaxid="+ajaxID;
					BX.ajax.insertToNode(basketUrl+getUrl, 'comp_'+ajaxID);
				}
					
			},
			
			enterCoupon : function(){
				$("#coupon").on("change", methods.ajaxEnterCoupon);
				$("input[name=BasketRefresh]").on("click", methods.ajaxEnterCoupon);
			},
			
			ajaxEnterCoupon : function(e){
				e.preventDefault();
				BX.showWait();
				couponVal = $("#coupon").val();
				postData = {
					'msCalculateBasket': "Y",
					'sessid': BX.bitrix_sessid(),
					'COUPON': couponVal,
				};
				BX.ajax({
					url: basketUrl,
					method: 'POST',
					data: postData,
					dataType: 'json',
					onsuccess: function(result)
					{   
						BX.closeWait();
						if(result["RESULT"]=="SUCCESS")
						{
							$("#coupon").removeClass("error");
							$("#coupon").addClass("success");
							methods.sendQuery();	
						}else{
							$("#coupon").removeClass("success");
							$("#coupon").addClass("error");	
						}
					}
				});	
			},
			
			ajaxBasket : function(){
				BX.addCustomEvent("onAjaxSuccess", methods.ajaxBasketFunc);
			},
			
			ajaxBasketFunc : function(){
				url = "ajax_top_basket=Y&preview=1&sessid="+BX.bitrix_sessid();
				$.post( basketUrl, url, function( data ) {
					$("#basket form").html(data);
				});	
			}		 
		}
	
		return this.each(function() {
			containerMain = options["containerMain"];
			contProps = options["contProps"];
			contItemProps = options["contItemProps"];
			contItemActive = options["contItemActive"];
			
			attrItemProps = options["attrItemProps"];
			attrItemID = options["attrItemID"];
			attrItemProperty = options["attrItemProperty"];
			itemActive = options["itemActive"];
			nameProps = options["nameProps"];
			nameMainVar = options["nameMainVar"];
			basketUrl = options["basketUrl"];

			methods.calculate();
			methods.enterCoupon();
			methods.ajaxBasket();

		});
		
	};
})(jQuery);