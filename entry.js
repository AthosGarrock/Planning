
$(function(){//works with jQuery
//Le but sera d'afficher l'entrée du jour, ainsi que la possibilité de le modifier si nécéssaire

//--------------------------Obtient les informations liées à ce jour. [GET]
$('.dates li:not(.mask)').click(function(){
	//Affiche la bulle
		$('.toggle').show();
	//let (Variables)
		let arrtest = $(this).attr('id').split('-');
		let day = arrtest[1]+'-'+arrtest[2]+'-'+arrtest[3];
		let theme = $(this).attr('theme')
	//Ajoute les informations du jour choisi par l'user.
		$('.date').val(day);
		$('.day-select').html(arrtest[3]+'/'+arrtest[2]+'/'+arrtest[1]);

		if (typeof theme !== 'undefined') {
			$('.theme_display').html(theme.toUpperCase().replace(/_/g," "));
			$('.delete.day-entry').show();
			$('.btn-entry').html('Modifier le theme');
		} else {
			$('.delete.day-entry').hide();
			$('.btn-entry').html('Ajouter une nouvelle entrée');
		}
		
		//Gestion des activités 
		$.getJSON('Ajax/processAJAX.php', {"e_id": $(this).attr('entry'), "attr":theme}, function(dGet){

			//Affiche la couleur associée au thème. 
				$('.theme_display').css({backgroundColor: dGet.color});
				if (!dGet.color) {$('.theme_display').css({backgroundColor: 'darkgrey'});}

			//Affiche la catégorie journalière par défaut.
				Array.from($('#theme option')).forEach(function(opt){

					if (typeof theme !== 'undefined' && $(opt).val() ==  theme.trim() ) {
						$(opt).attr('selected', 'selected');
					}

				});
			// Returns time in minutes.
			function timeToInt(time){
				let totalMin = null;

				if (typeof time !== 'undefined') {
					let hours = parseInt(time[0]+time[1]);
					totalMin = hours*60+parseInt(time[3]+time[4]);
				}
				return totalMin;
			}

			let i = 0;

			console.log(dGet);

			//Si des entrées ont été récupérées
			if (typeof dGet.entry == 'object') {

				$('#graph').show();

				dGet.entry.forEach(function(e){
					i++;
					
					//Eléments ajoutés

					let div = document.createElement('div'); //Element visuel (jauge journalière)

					//Article/Entrées mixtes
					let art = document.createElement('article'); //Ensemble des donnees relatives à l'act
					$(art).attr({entry: e.id});

					let act = e.activite; //Contenu de l'activité

					//Catégorie de l'activite
						let title = document.createElement('h4'); 
						$(title).html(act+' ');
						$(title).addClass('cell');

					//Précisions
						let p = document.createElement('p'); 
						$(p).html(e.content);
						$(p).addClass('cell');

					//Tranche horaire
					let duree = document.createElement('span');
					$(duree).addClass('time-act');
					$(duree).addClass('cell');
						//Nous n'utilisons que les heures et minutes.
						let aStart = e.e_start;
						aStart = aStart.substr(-aStart.length, 5)
						// let aEnd = e.e_end;
						// aEnd = aEnd.substr(-aEnd.length, 5)

						$(duree).html(aStart+' ');


					//Flag for deletion.
					let delElt = $('<input type="checkbox" class="del-entry" name="del-'+e.id+'"> ');
					$(delElt).click(function(){
						$.post('Ajax/processAJAX.php', {delete: 'act', e_start: e.e_start}, function(dPost) {
							console.log(e.e_start);
						})
					})

					//-------------------------Modifie une activité [EDIT]
						$(title).click(function() {

							$(this).replaceWith("<div><select name='edit_activite["+e.id+"]' required></select></div>");
							//Récupère la liste des  activités pour les intégrer dans select.
							$.getJSON('Ajax/select.php', function(dGet){
								
								let options = '';

								dGet.forEach(function(opt){
									options += '<option>'+opt.name+'</option>';
								})

								$("[name='edit_activite["+e.id+"]']").html(options);	
							})
							$('#erase').show();
						});

						$(p).click(function(){
							$(this).replaceWith("<div><input type='text' name='edit_content["+e.id+"]' required></div>");
							$('#erase').show();
						})

					//Intégration dans l'article;
						$(art).append(title);
						$(art).append(duree);
						$(art).append(p);
						$(art).append(delElt);

					//Intégration dans l'entrée;
						$('#daydata').append(art);



					// let start = timeToInt(e.e_start);
					// let end = timeToInt(e.e_end);


					// //Formule à peaufiner
					// let wth = (end-start)*100/(60*8);
					

					// $(div).css({backgroundColor: dGet[act]['color'], height:"100%", width:wth+'%', display:"inline-block"});
					// $('#graph').append(div);
	
				})					
			} else {
				$('#graph').hide()
				let p = document.createElement('p');
				$(p).html('Aucune information.')
				$('#daydata').append(p); 
			}
		});

	//Si une entrée a été selectionnée pour effacement [EDIT/DELETE]
		$('#daydata').change(function(){
			if ($("input:checkbox").is(":checked") || $('#form1 input').val() || $('#form1 select').length != 0) {
				$('#erase').show();
			} else {
				$('#erase').hide();
			}
		})

		$('#entry').show(); 


	//-------------------------Efface toutes les infos de ce jour.

	$('.delete.day-entry').click(function(){
		if (window.confirm('Voulez-vous vraiment effacer toutes les informations liées à ce jour?')) {
			$.post('Ajax/processAJAX.php', {delete: 'day', d_start: day}, function(dPost) {
				console.log(day);
			})			
		}

	})
}) 

//-------------------------Affiche un formulaire d'ajout d'entrée. 
$('.btn-entry').click(function(){
	$('#entry').toggle(); 
	$('.enform').toggle();

	switch ($('#theme').val()) {
		case 'Mixte':
			$('.details, #period').css('display','block');
			$('textarea').css('display', 'block');

			//Hide useless elements and empties them
				$('.d_end, .days').css('display','none');
				$('.d_end, .days').val(null);
				$('.days input').prop('checked', false);
			break;
		case 'Stage':
			$('.d_end, .days').css('display','inline-block');
			$('textarea').css('display', 'block');
			$('.date').val($('[name=d_start]').val());
			//Hide useless elements and empties them
				$('.details, #period').css('display','none');
				$('.details, #period').val(null);
				$('.days input').prop('checked', false);
			break;
		case 'Abs':
			$('#period').css('display','block');
			//Hide useless elements and empties them
				$('.details, .d_end, .days').css ('display','none');
				$('.details, .d_end, .days').val(null);
				$('.days input').prop('checked', false);
				$('textarea').css('display', 'none');
			break;
		default:
			$('textarea').css('display', 'block');
			//Hide useless elements and empties them
			$('.details, .d_end, #period, .days').css('display','none');
			$('.days input').prop('checked', false);
			$('.details, .d_end, #period, .days').val(null);
			break;
	}
})

//-------------------------Envoi du formulaire à la page process.php [POST]
$('#form2').submit(function(e){
	e.preventDefault();
	let form = $(this).serialize();
	console.log(form);

	$.post('Ajax/processAJAX.php', form, function(dPost) {
		console.log(dPost);
	});
})

//-------------------------Modifie le formulaire selon le choix de l'utilisateur.
$('#theme').change(function(){
	switch ($(this).val()) {
		case 'Mixte':
			$('.details, #period').css('display','block');
			$('textarea').css('display', 'block');

			//Hide useless elements and empties them
				$('.d_end, .days').css('display','none');
				$('.d_end, .days').val(null);
				$('.days input').prop('checked', false);
			break;
		case 'Stage':
			$('.d_end, .days').css('display','inline-block');
			$('textarea').css('display', 'block');
			$('.date').val($('[name=d_start]').val());
			//Hide useless elements and empties them
				$('.details, #period').css('display','none');
				$('.details, #period').val(null);
				$('.days input').prop('checked', false);
			break;
		case 'Abs':
			$('#period').css('display','block');
			//Hide useless elements and empties them
				$('.details, .d_end, .days').css ('display','none');
				$('.details, .d_end, .days').val(null);
				$('.days input').prop('checked', false);
				$('textarea').css('display', 'none');
			break;
		default:
			$('textarea').css('display', 'block');
			//Hide useless elements and empties them
			$('.details, .d_end, #period, .days').css('display','none');
			$('.days input').prop('checked', false);
			$('.details, .d_end, #period, .days').val(null);
			break;
	}
})


//-------------------------Ajoute une activité. [ADD]
$('#add-act').click(function(e) {
	$('#add').clone().appendTo('.details');
});

//-------------------------Efface ou modifie une activité [EDIT/DELETE]

$('#form1').submit(function(e){
	e.preventDefault();
	let form = $(this).serialize();

	$.post('Ajax/edit.php', form, function(dPost, textStatus, xhr) {
		console.log(form);
		console.log(dPost);
	});
})


//-------------------------Permet de cliquer sur le formlaire sans le fermer automatiquement.
$('#ctn').click(function(e){
	e.stopPropagation();
})

//-------------------------Ferme l'entrée. [CLOSE]
$('.toggle').click(function(){
	$('.toggle').hide();
	$('#entry').hide(); 
	$('.enform').hide();
	$('#erase').hide();
	
	$('#daydata').html('');
	$('#graph').html('');
	$('.theme_display').html('');

	$('.delete.day-entry').off();
})




});// $(function{}()) END, do not delete.


