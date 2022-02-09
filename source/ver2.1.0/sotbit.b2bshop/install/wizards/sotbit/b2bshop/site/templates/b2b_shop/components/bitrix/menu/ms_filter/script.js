$(document).ready(function(){     
	
    $(document).on("click", ".left_top_menu .open_close_menu", function(e){ 
    	
    	var Sitedir=$(this).closest('.left_top_menu').data('site-dir');
    	var Url=$(this).closest('.left_top_menu').data('site-url');
    	var Code=$(this).closest('.dropdown').data('code');
    	
    	
    	if($(this).closest('.dropdown').hasClass("li-open"))
    	{
    		var Open = "1";
    	}
    	else
    	{
    		var Open = "0";
    	}
    	
		$.ajax({
			type: 'POST',
			url:'/include/ajax/filter.php',
			data: {Url:Url,Code:Code,Open:Open},
			success: function(data){},
			error:  function (jqXHR, exception) {}
		});
    });
});