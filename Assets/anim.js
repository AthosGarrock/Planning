$('nav').prepend('<div class="closeMenu">X</div>');

$('.closeMenu').click(function(){
	$('#nav').slideToggle();
})



Array.from($('#nav li')).forEach(function(li){

	$(li).hover(
		function(){
			$(this.querySelector('.sub_menu')).slideDown();
		}, 

		function(){
			$(this.querySelector('.sub_menu')).hide();
		}
	)

})



