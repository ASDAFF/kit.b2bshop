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

	$(document).on("change", ".smartfilter input, .smartfilter select", function(e){
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
	})

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
			url += "&del_filter=1";
			BX.ajax.insertToNode(url, 'comp_'+bxAjaxID);
		}
		return false;
	})

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
})