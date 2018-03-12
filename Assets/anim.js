$(function(){
	$('nav').prepend('<div class="closeMenu">X</div>').click(function(){
		$('#nav').slideToggle();
	})

	//Permet d'afficher les sous-menu associés on hover
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
})




