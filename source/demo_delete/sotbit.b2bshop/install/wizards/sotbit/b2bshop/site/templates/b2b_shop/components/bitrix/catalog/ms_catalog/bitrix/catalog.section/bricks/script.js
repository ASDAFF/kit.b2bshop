$(window).on('load', function () 
{
	if ($(window).width() <= '998' && $(window).width() >= '768') //for ipad bugs
	{
		Masonry();
		Masonry();
		Masonry();
	}
	Masonry();

});



window.onresize = function()
{
	if ($(window).width() <= '767' && $(window).width() >= '300')//for iphone bugs
	{
		Masonry();
		Masonry();
		Masonry();
	}
	Masonry();
}

function Masonry()
{
	var MinWidth = Math.round($("#bricks").width()/5);
	if(MinWidth<50)
	{
		MinWidth = 50;
	}

	var BrickWidth = 234;
	
	for (var i = 1; i < 5; i++) 
	{
		if($('#bricks .grid-item--width'+i).length > 0)
		{
			var BrickWidth = $('#bricks .grid-item--width'+i).width();
			BrickWidth = BrickWidth/i;
			$('#bricks grid-sizer').width(BrickWidth)
			break;
		}
	}
	for (var i = 1; i < 5; i++) 
	{
		if($('#bricks .grid-item--height'+i).length > 0)
		{
			$('#bricks .grid-item--height'+i).height(BrickWidth*i);
		}
	}

	$('#bricks').masonry({
		  itemSelector: '.grid-item',
		  columnWidth: MinWidth,
		  isFitWidth: true,
		});

}