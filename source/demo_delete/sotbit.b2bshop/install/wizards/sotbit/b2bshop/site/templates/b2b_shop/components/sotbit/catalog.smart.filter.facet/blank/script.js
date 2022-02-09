$(document).ready(function(){
	$(document).on("click", ".block_form_filter .filter_block", function(e){

		var Sitedir=$(this).closest('.block_form_filter').data('site-dir');
		var Url=$(this).closest('.block_form_filter').data('site-url');
		var Code=$(this).data('code');


		if($(this).hasClass("block_open"))
		{
			var Open = "Y";
		}
		else
		{
			var Open = "N";
		}

		$.ajax({
			type: 'POST',
			url: SITE_DIR + 'include/ajax/filter.php',
			data: {Url:Url,Code:Code,Open:Open},
			success: function(data){},
			error:  function (jqXHR, exception) {}
		});
	});

	$(document).on("change", ".outer_checkbox .checkbox", function(e)
	{
		form = $(this).closest("form").eq(0);
		ajaxID = form.find("[name=bxajaxid]").attr("id");
		ajaxValue = form.find("[name=bxajaxid]").attr("value");
		var obForm = top.BX(ajaxID).form;
		BX.ajax.submitComponentForm(obForm, 'comp_'+ajaxValue, false);
		BX.submit(obForm, "save_"+$(this).attr('name'), "Y", function(){

		});
	});



	$(document).on("click", ".button_filter_block", function(e){

		bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
		if(bxAjaxID)
		{
			e.preventDefault();
			$(".smartfilter input[name=AJAX_CALL]").remove();
			param = $(".smartfilter").serialize();
			action = $(".smartfilter").attr("action");
			if(action.indexOf("?")>=0) url = action+"&"+param;
			else url = action+"?"+param;
			BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
		}
	});




	$(document).on("submit", ".smartfilter", function(e){
		bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
		if(bxAjaxID)
		{
			e.preventDefault();
			$(".smartfilter input[name=AJAX_CALL]").remove();
			param = $(".smartfilter").serialize();
			action = $(".smartfilter").attr("action");
			if(action.indexOf("?")>=0) url = action+"&"+param;
			else url = action+"?"+param;
			BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
		}
	});



	$(document).on("click", ".blank_filter_checked", function(e)
	{
		var code = $(this).attr('data-code');

		$('#filter_list_'+code).find('input[type=checkbox]').each(function(){
			$(this).prop( "checked", false );
			$(this).attr( "checked", false );
		});

		$('.filter_price').each(function()
		{
			if($(this).data('code') == code)
			{
				$(this).find('input[type=text]').each(function()
				{
					$(this).val('');
				});
			}
		});



		bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
		if(bxAjaxID)
		{

			e.preventDefault();
			$(".smartfilter input[name=AJAX_CALL]").remove();
			param = $(".smartfilter").serialize();
			action = $(".smartfilter").attr("action");
			if(action.indexOf("?")>=0) url = action+"&"+param;
			else url = action+"?"+param;
			BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
		}
	});



	$(document).on("click", ".del_form_filter", function(e){
		e.preventDefault();
		bxAjaxID = $(".smartfilter input[name=bxajaxid]").eq(0).val();
		if(bxAjaxID)
		{
			e.preventDefault();
			$(".smartfilter input[name=AJAX_CALL]").remove();
			param = $(".smartfilter").serialize();
			action = $(".smartfilter").attr("action");
			//param = getFilterParam(param);
			if(action.indexOf("?")>=0) url = action+"&"+param;
			else url = action+"?"+param;
			url += "&del_filter=1&was=1";
			BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
		}
		return false;
	});

	function getFilterParam(param)
	{
		var filterPath = "f/";
		$(".smartfilter .filter_block").each(function(){
			if($(this).find("input[type=checkbox]:checked").length>0)
			{
				_this = $(this).find("input[type=checkbox]:checked").eq(0);
				name = _this.attr("name").replace("[]", "");
				filterPath += name+"-";
				$(this).find("input[type=checkbox]:checked").each(function(i, v){
					val = $(this).val()
					if(i>0)filterPath += "-or-"+val;
					else filterPath += val;
					console.log("i="+i+"v="+v);
				})
				filterPath += "/";
			}
		})
		return filterPath;
	}
});
function filterList(header, list)
{
	$(header).change( function () {
		var filter = $(header).val();
		if(filter)
		{
			$matches = $(list).find('label:Contains(' + filter + ')').parent();

			$('li', list).not($matches).slideUp();
			$matches.slideDown();
		}
		else
		{
			$(list).find("li").slideDown();
		}
		return false;
	})
		.keyup( function ()
		{
			$(this).change();
		});
}

(function ($)
{
	jQuery.expr[':'].Contains = function(a,i,m)
	{
		return (a.textContent || a.innerText || "").trim().toUpperCase().indexOf(m[3].toUpperCase())==0;
	};
}(jQuery));


jQuery(document).click(function(e){

	var doit = 1;

	if($(e.target).attr('class') == undefined)
	{
		doit = 0;
	}
	else
	{
		if($(e.target).attr('class').indexOf('block_name') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('blank_categorii') != -1)  doit = 0;
		if($(e.target).attr('class').indexOf('blank_excel_in_text') != -1)  doit = 0;
		if($(e.target).attr('class').indexOf('blank_excel_out_text') != -1)  doit = 0;
		if($(e.target).attr('class').indexOf('blank_resizer_tool') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('box__file') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('check') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('find_property_value') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('fancybox-close') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('blank_list') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('dropdown') != -1) doit = 0;
		if($(e.target).attr('class').indexOf('open_close_menu') != -1) doit = 0;
	}

	if(doit == 1)
	{
		var Url=$('.block_form_filter').data('site-url');
		$('.filter_block').each(function(){
			if($(this).hasClass('block_open'))
			{
				$(this).find('.inner_filter_block').stop(true, false).slideUp("slow");
				var Code = $(this).data('code');
				var Open = 'N';
				$.ajax({
					type: 'POST',
					url: SITE_DIR + 'include/ajax/filter.php',
					data: {Url: Url, Code: Code, Open: Open},
					success: function (data)
					{
					},
					error: function (jqXHR, exception)
					{
					}
				});
			}
		});
		$('#blank_list').fadeOut();
		$('#excel_in_form').fadeOut();
	}
});