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
		this.arParams = arParams["arParams"];
		this.filter = arParams["filter"];
		this.qnts = arParams["qnts"];
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
				var rand = Math.random();
				link.setAttribute('href',arr[0]);
				link.setAttribute('download',arr[1]);
				link.setAttribute('id',rand);
				
				$('body').append(link);
			    var event = document.createEvent("MouseEvents");
		        event.initMouseEvent(
		                "click", true, false, window, 0, 0, 0, 0, 0
		                , false, false, false, false, 0, null
		        );
		        
		        link.dispatchEvent(event);
		        $('#'+rand).remove();
			},
			error:  function (jqXHR, exception) {
			}
		});
	}
})(window, document, jQuery);
!function ($) {
	'use strict';
	// TAB CLASS DEFINITION
	// ====================

	var Tab = function (element) {
		// jscs:disable requireDollarBeforejQueryAssignment
		this.element = $(element)
		// jscs:enable requireDollarBeforejQueryAssignment
	}

	Tab.VERSION = '3.3.7'

	Tab.TRANSITION_DURATION = 150

	Tab.prototype.show = function () {
		var $this    = this.element
		var $ul      = $this.closest('ul:not(.dropdown-menu)')
		var selector = $this.data('target')

		if (!selector) {
			selector = $this.attr('href')
			selector = selector && selector.replace(/.*(?=#[^\s]*$)/, '') // strip for ie7
		}

		if ($this.parent('li').hasClass('active')) return


		var $previous = $ul.find('.active:last a')
		var hideEvent = $.Event('hide.bs.tab', {
			relatedTarget: $this[0]
		})
		var showEvent = $.Event('show.bs.tab', {
			relatedTarget: $previous[0]
		})

		$previous.trigger(hideEvent)
		$this.trigger(showEvent)

		if (showEvent.isDefaultPrevented() || hideEvent.isDefaultPrevented()) return

		var $target = $(selector)

		this.activate($this.closest('li'), $ul)
		this.activate($target, $target.parent(), function () {
			$previous.trigger({
				type: 'hidden.bs.tab',
				relatedTarget: $this[0]
			})
			$this.trigger({
				type: 'shown.bs.tab',
				relatedTarget: $previous[0]
			})
		})
	}

	Tab.prototype.activate = function (element, container, callback) {
		var $active    = container.find('> .active')
		var transition = callback
			&& $.support.transition
			&& ($active.length && $active.hasClass('fade') || !!container.find('> .fade').length)

		function next() {
			$active
				.removeClass('active')
				.find('> .dropdown-menu > .active')
				.removeClass('active')
				.end()
				.find('[data-toggle="tab"]')
				.attr('aria-expanded', false)

			element
				.addClass('active')
				.find('[data-toggle="tab"]')
				.attr('aria-expanded', true)

			if (transition) {
				element[0].offsetWidth // reflow for transition
				element.addClass('in')
			} else {
				element.removeClass('fade')
			}

			if (element.parent('.dropdown-menu').length) {
				element
					.closest('li.dropdown')
					.addClass('active')
					.end()
					.find('[data-toggle="tab"]')
					.attr('aria-expanded', true)
			}

			callback && callback()
		}

		$active.length && transition ?
			$active
				.one('bsTransitionEnd', next)
				.emulateTransitionEnd(Tab.TRANSITION_DURATION) :
			next()

		$active.removeClass('in')
	}


	// TAB PLUGIN DEFINITION
	// =====================

	function Plugin(option) {
		return this.each(function () {
			var $this = $(this)
			var data  = $this.data('bs.tab')

			if (!data) $this.data('bs.tab', (data = new Tab(this)))
			if (typeof option == 'string') data[option]()
		})
	}

	var old = $.fn.tab

	$.fn.tab             = Plugin
	$.fn.tab.Constructor = Tab


	// TAB NO CONFLICT
	// ===============

	$.fn.tab.noConflict = function () {
		$.fn.tab = old
		return this
	}


	// TAB DATA-API
	// ============

	var clickHandler = function (e) {
		e.preventDefault()
		Plugin.call($(this), 'show')
	}

	$(document)
		.on('click.bs.tab.data-api', '[data-toggle="tab"]', clickHandler)
		.on('click.bs.tab.data-api', '[data-toggle="pill"]', clickHandler)

}(jQuery);