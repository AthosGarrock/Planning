
	var btn = document.querySelector('button');
	let entries = $('.ctn .row').not('.title');

//Fonctions
	//Actualise la page.
		function actualize(entries, dP){
			entries = $('.ctn .row').not('.title');
			entries.remove();	
				dP.forEach(function(ctg){
					let ctn = $('<div class="row zoom"></div>');
					ctn.append('<div class="name"><span class="del" id="'+ctg.id+'">X</span>'+ctg.name.replace(/_/g, ' ')+'</div>');
					ctn.append('<div class="name ini">'+ctg.initials+'</div>');

					let color = $('<div class="color"></div>');
					color.css('backgroundColor', ctg.color);
					ctn.append(color);

					if(ctg.type == 'theme'){
						$('#theme').append(ctn);
					} else{
						$('#act').append(ctn);
					}
				})
		}

	//DELETE ENTRY
		function delClick(){
			entries = $('.ctn .row').not('.title');

			//Petite fonction esthétique
				entries.hover(function() {
					$(this).children().children('.del').animate({opacity: 1});
				}, function() {
					$(this).children().children('.del').animate({opacity: 0});
				});
			//Actual delete event
				$('.del').click(function(event) {
					if(window.confirm("Voulez-vous vraiment effacer la catégorie"+$(this).parent().text())){
						//Get the id of category you want to delete
						let del_id = $(this).attr('id');
						//Send the request
						$.post('processCategory.php', {del_id: del_id}, function(dP){
							let dPost = JSON.parse(dP);
							actualize(entries, dPost);
						}).done(function(){
							delClick();
						})
					}
		});
		}

		delClick();

//[ADD - Ajout]Affiche un formulaire d'insertion.
	btn.addEventListener('click', function(e){
		//Ajoute de l'ombre sur l'écran.
		let ctn = document.createElement('div')
		ctn.className = 'ctn-veil';

		let form = document.createElement('form');
		$(form).addClass('add');		
		form.innerHTML = '<h2>Ajouter un nouvel élément</h2>';

		//Champs du formulaire
			let nameF = document.createElement('fieldset');
			let iniF = nameF.cloneNode(false);
			let typeF = nameF.cloneNode(false);
			let colorF = nameF.cloneNode(false);

			let fieldArray = [nameF, iniF, typeF, colorF];

			nameF.innerHTML = '<label>Nom : </label><input type="text" name="name" required><br>';
			iniF.innerHTML = '<label>Initiales : </label><input type="text" name="ini" required><br>';
			typeF.innerHTML = '<label>Type : </label><select name="type" required><option value="theme">Thème</option><option value="activite">Activité</option></select><br>';
			colorF.innerHTML = '<label>Couleur : </label><input type="color" name="color" required><br>';

		//Un bouton fermeture
			let close = document.createElement('span');
			close.innerHTML = 'X';
			close.className = 'close';

		//Append each field to form.
			fieldArray.forEach(function(field){
				form.appendChild(field);
			})
		
		//Submit button and related submit code.
			let submit = document.createElement('input');
			submit.setAttribute("type", "submit");

			
			$(form).submit(function(e){
				e.preventDefault();

				let data = $(form).serialize();

				$.post('processCategory.php', data, function(dPost){
					let dP = JSON.parse(dPost);
					actualize(entries, dP);
				}).done(function(){
					delClick();
				});
			})

		//Display form		
			form.appendChild(close);
			form.appendChild(submit);			
			ctn.appendChild(form);
			document.body.appendChild(ctn);

			form.addEventListener('click',function(e){
				e.stopPropagation();
			});

			ctn.addEventListener('click', function(){
				document.body.removeChild(ctn);
			})
	})


//[EDIT - Modifier]
 	let data = $('.name');

 	data.click(function(event) {
 		$(this).replaceWith('<div><input type="text"></div>');
 	});
