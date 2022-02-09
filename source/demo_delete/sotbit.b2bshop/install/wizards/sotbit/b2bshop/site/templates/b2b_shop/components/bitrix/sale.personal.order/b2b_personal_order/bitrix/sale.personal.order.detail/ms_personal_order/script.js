BX.namespace('BX.Sale.PersonalOrderComponent');
(function(window, document, $, undefined) {

	var ExcelButtonId = "";
	var arResult = "";
	var TemplateFolder = "";
	var OrderId = "";
	var Headers = "";
	var HeadersSum = "";
	window.msOrderDetail = function(arParams) {
		this.ExcelButtonId = arParams["ExcelButtonId"];
		this.ajaxUrl = arParams["ajaxUrl"];
		this.paymentList = arParams["paymentList"];
		this.changePayment = arParams["changePayment"];
		this.changePaymentWrapper = arParams["changePaymentWrapper"];
		this.arResult = arParams["arResult"];
		this.TemplateFolder = arParams["TemplateFolder"];
		this.OrderId = arParams["OrderId"];
		this.Headers = arParams["Headers"];
		this.HeadersSum = arParams["HeadersSum"];
		this.destroy();
		this.init();
	}
	window.msOrderDetail.prototype.destroy = function() {

	}
	window.msOrderDetail.prototype.init = function() {
		$(document).on("click", this.ExcelButtonId, this, this.clickExcelButton);
		$(document).on("click", this.changePayment, this, this.clickchangePayment);
	}
	
	window.msOrderDetail.prototype.clickchangePayment = function(e) {
		_this = e.data;

		BX.ajax(
				{
					method: 'POST',
					dataType: 'html',
					url: _this.ajaxUrl,
					data:
					{
						sessid: BX.bitrix_sessid(),
						orderData: _this.paymentList[$(this).attr('id')]
					},
					onsuccess: BX.proxy(function(result)
					{
						$(this).closest(_this.changePaymentWrapper).html(result);
					},this),
					onfailure: BX.proxy(function()
					{
						return this;
					}, this)
				}, this
			);
	}
	
	window.msOrderDetail.prototype.clickExcelButton = function(e) {
		_this = e.data;
		$.ajax({
			type: 'POST',
			url: _this.TemplateFolder+'/ajax.php',
			data: {arResult:_this.arResult,OrderId:_this.OrderId,Headers:_this.Headers,HeadersSum:_this.HeadersSum},
			success: function(data){
				var arr = data.split("||");
				var link = document.createElement('a');
				link.setAttribute('href',arr[0]);
				link.setAttribute('download',arr[1]);
			    var event = document.createEvent("MouseEvents");
		        event.initMouseEvent(
		                "click", true, false, window, 0, 0, 0, 0, 0
		                , false, false, false, false, 0, null
		        );
		        link.dispatchEvent(event);
			},
			error:  function (jqXHR, exception) {
			}
		});
	}
})(window, document, jQuery);