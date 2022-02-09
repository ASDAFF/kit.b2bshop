(function( window, document, $, undefined) {
	window.msOrderPhonePreviewDetail = function(arParams)
	{
		this.destroy();
		this.init();
	};
	
	window.msOrderPhonePreviewDetail.prototype.init = function()
	{
		$(".detail_page_wrap.preview .sotbit_order_phone form input[name='AJAX_CALL']", ".sotbit_order_phone form input[name='bxajaxid']").remove();
		this.maska = $(".detail_page_wrap.preview .sotbit_order_phone form input[name='TEL_MASK']").eq(0).val();
		this.maska = $.trim(this.maska);
		if(this.maska!="")$(".detail_page_wrap.preview .sotbit_order_phone form input[name='order_phone']").mask(this.maska, {placeholder:"_"});
		$(document).on("submit", ".detail_page_wrap.preview .sotbit_order_phone form", this, this.submitOrderPhone);	
	};
	
	window.msOrderPhonePreviewDetail.prototype.destroy = function()
	{
		$(document).off("submit", ".detail_page_wrap.preview .sotbit_order_phone form", this.submitOrderPhone);	
	};
	
	window.msOrderPhonePreviewDetail.prototype.submitOrderPhone = function(e)
	{
		e.preventDefault();
		_this = e.data;
		
		v = $(this).find("input[name='TEL_MASK']").val();
		v = $.trim(v);
		req = _this.strReplace(v);
		var this_cont = $(this);
		v = $(this).find("input[type='text']").val();
		cont_modal = $(".detail_page_wrap.preview .sotbit_order_phone form input:submit").eq(0);
		noTelText = $(".detail_page_wrap.preview .sotbit_order_phone form input[name='ERROR_TEXT']").val();
		successText = $(".detail_page_wrap.preview .sotbit_order_phone form input[name='SUCCESS_TEXT']").val();
		id = parseInt($(".detail_page_wrap.preview .sotbit_order_phone form input[name='PRODUCT_ID']").val());
		if(!isNaN(id) && id && v.search(req)!=-1 || v=="")
		{
			$(this).find("input[type='text']").removeClass("red");
			ser = $(this).serialize();
			$.post("/bitrix/components/sotbit/order.phone/ajax.php", ser, function(data){
				data = $.trim(data);
				if(data.indexOf("SUCCESS")>=0)
				{
					this_cont.find(".sotbit_order_success").show();
					id = data.replace("SUCCESS", "");
					localHref = $('input[name="LOCAL_REDIRECT"]').val();
					orderID = $('input[name="ORDER_ID"]').val();
					changeButton('.detail_page_wrap.preview .sotbit_order_phone form .wrap_input', successText, '','back_call_submit', 'back_call_submit_change')
					if(typeof(localHref) != "undefined" && localHref!="")
					{
						location.href = localHref+"?"+orderID+"="+id;	
					}
				}else{
					open_small_modal(cont_modal, 'class_wish', noTelText);	
				}
			})

		}else if(!isNaN(id) && id){
			$(this).find("input[type='text']").addClass("red");
			cont_modal
			open_small_modal(cont_modal, 'class_wish', noTelText);
		}
		BX.closeWait();
		return false;
	};
	
	window.msOrderPhonePreviewDetail.prototype.strReplace = function(str)
	{
		str = str.replace("+", "\\+");
		str = str.replace("(", "\\(");
		str = str.replace(")", "\\)");
		str = str.replace(/[0-9]/g, "[0-9]{1}");
		return new RegExp(str, 'g');;

	};
		
})(window, document, jQuery);