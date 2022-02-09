(function( $ ) {
	$.fn.msCalculateBasketOrder = function(options) {
		var basketItem = "";
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
		var _this = "";
		var basketUrl = "";
		
		var methods ={
			calculate : function(){
				$(document).on("submit",'#basket_form',function(e){
					setTimeout(function(){BX.closeWait();},700);
				});
				$(document).on("click", containerMain+" "+contProps+" "+contItemProps, function(e){ 
					if($(this).is(".li-disable")) return false;
					_this = $(this); 
					arOfferId = $(this).attr("data-offer").split(",");
					mainParent = $(this).parents(containerMain).eq(0);
					parent = $(this).parents(contProps).eq(0);
					currentUl = mainParent.find(contProps).index(parent);
					arOffer = mainParent.find(contProps).eq(0).find(contItemActive).eq(0).attr("data-offer").split(",");
					offerID = 0;
					arOfferId = $(this).attr("data-offer").split(",");
					mainParent.find(contProps).each(function(i, v){
						if(i>currentUl)
						{
							$(this).find(contItemProps).each(function(){
								arOfferAttr = $(this).attr("data-offer").split(",");
								bool = false;
								$(this).removeClass("li-disable");
								$.each(arOfferAttr, function(attrI, attrV){
									if($.inArray(attrV, arOfferId)>-1) bool = true;
								})
								if(!bool){
									$(this).addClass("li-disable");
									$(this).removeClass("li-active");
								}
							})
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
				action = $("#basket_form").attr("action");
                action = '/include/ajax/basket_add_product_and_wish.php';
				if(_this)
				{
					container = _this.parents(containerMain).eq(0); 
					basketItemId = _this.attr(attrItemID); 
					ajaxID = _this.attr("data-ajax");
					
					if(action.indexOf("?")>=0)
					{
						getUrl = action+"&"+nameMainVar+"=Y&basketItemId="+basketItemId+"&bxajaxid="+ajaxID;	
					}else{
						getUrl = action+"?"+nameMainVar+"=Y&basketItemId="+basketItemId+"&bxajaxid="+ajaxID;	
					}
					
					strProps = "";
					container.find(contProps+" "+contItemProps+itemActive).each(function(){
						prop = $(this).attr(attrItemProperty);
						val = $(this).attr(attrItemProps);
						strProps += prop+",";
						getUrl += "&"+nameProps+"["+prop+"]="+val;	
					})
					BX.ajax.insertToNode(getUrl+"&offers_props="+strProps+"&offerID="+offerID, 'comp_'+ajaxID);	
				}else{
					ajaxID = $(containerMain+" "+contProps+" "+contItemProps).eq(0).attr("data-ajax");
					if(action.indexOf("?")>=0)
					{
						getUrl = action+"&"+nameMainVar+"=Y&bxajaxid="+ajaxID;	
					}else{
						getUrl = action+"?"+nameMainVar+"=Y&bxajaxid="+ajaxID;	
					}
					BX.ajax.insertToNode(getUrl, 'comp_'+ajaxID); 
						   
				}
				//if($(basketItem).length>0)
				submitForm('N');   
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
							//submitForm('N');	
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
			basketItem = options["basketItem"];
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