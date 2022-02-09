$(document).ready(function() {
	$('.top-block__wrapper__dropmenu').on('click', function () {
		$('.top-block__dropmenu').slideToggle(0);
		$('.top-block__wrapper__dropmenu__title').toggleClass('top-block__wrapper__dropmenu__title-down');
	});
	if(window.innerWidth<768) 
	{
		$("#b2btop_lk__sm").append($('.top-block__wrapper__dropmenu'));
	}
});