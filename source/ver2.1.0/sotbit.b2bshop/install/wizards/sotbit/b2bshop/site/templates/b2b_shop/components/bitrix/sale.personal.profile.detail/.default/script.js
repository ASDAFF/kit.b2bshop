BX.namespace('BX.Sale.PersonalProfileComponent');

(function() {
	BX.Sale.PersonalProfileComponent.PersonalProfileDetail = {
		init: function ()
		{
			var propertyFileList = document.getElementsByClassName('sale-personal-profile-detail-property-file');
			Array.prototype.forEach.call(propertyFileList, function(propertyFile)
			{
				var deleteFileElement = propertyFile.getElementsByClassName('profile-property-input-delete-file')[0];
				var inputFile = propertyFile.getElementsByClassName('sale-personal-profile-detail-input-file')[0];
				var labelFileInfo = propertyFile.getElementsByClassName('sale-personal-profile-detail-load-file-info')[0];
				var cancelButton = propertyFile.getElementsByClassName('sale-personal-profile-detail-load-file-cancel')[0];

				BX.bindDelegate(propertyFile, 'click', { 'class': 'profile-property-check-file' }, BX.proxy(function(event)
				{
					if (deleteFileElement.value != "")
					{
						idList = deleteFileElement.value.split(';');
						if (idList.indexOf(event.target.value) === -1)
						{
							deleteFileElement.value = deleteFileElement.value + ";" + event.target.value;
						}
						else
						{
							idList.splice(idList.indexOf(event.target.value), 1);
							deleteFileElement.value = idList.join(";");
						}
					}
					else
					{
						deleteFileElement.value = event.target.value;
					}
				}, this));

				BX.bind(inputFile, 'change', BX.delegate(
					function(event)
					{
						if (event.target.files.length > 1)
						{
							labelFileInfo.innerHTML = BX.message('SPPD_FILE_COUNT') + event.target.files.length;
							cancelButton.classList.remove("sale-personal-profile-hide");
						}
						else if (event.target.files.length == 1)
						{
							fileName = event.target.files[0].name;
							if (fileName.length > 40)
							{
								labelFileInfo.innerHTML = fileName.substr(0,9) + "..." + fileName.substr(-9);
							}
							else
							{
								labelFileInfo.innerHTML = event.target.files[0].name;
							}
							cancelButton.classList.remove("sale-personal-profile-hide");
						}
						else
						{
							cancelButton.classList.add("sale-personal-profile-hide");
							labelFileInfo.innerHTML = BX.message('SPPD_FILE_NOT_SELECTED');
						}
					}, this)
				);
				BX.bind(cancelButton, 'click', BX.delegate(
					function()
					{
						cancelButton.classList.add("sale-personal-profile-hide");
						labelFileInfo.innerHTML = BX.message('SPPD_FILE_NOT_SELECTED');
						inputFile.value = "";
						inputFile.files = [];
					}, this)
				);
			});
		}
	}
})();
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