
	var btn = document.querySelector('button');

//Affiche un formulaire d'insertion.
	btn.addEventListener('click', function(e){
		//Ajoute de l'ombre sur l'écran.
		let ctn = document.createElement('div')
		ctn.className = 'ctn-veil';

		let form = document.createElement('form');
		
		form.innerHTML = '<h2>Ajouter un nouvel élément</h2>';

		//Champs du formulaire
		let field = document.createElement('fieldset');
		let field2 = field.cloneNode(false);
		let field3 = field.cloneNode(false);

		let fieldArray = [field, field2, field3];

		field.innerHTML = '<label>Nom : </label><input type="text" name="name" required><br>';
		field2.innerHTML = '<label>Type : </label><select name="type" required><option value="theme">Thème</option><option value="activite">Activité</option></select><br>';
		field3.innerHTML = '<label>Couleur : </label><input type="color" name="color" required><br>';

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
					let ctnAjax = document.querySelector('.ctn-ajax');
					ctnAjax.innerHTML = '';

					dP.forEach(function(ctg){
						let rowEl = document.createElement('div');
						rowEl.className = 'row';

						let name = document.createElement('div');
						name.className = 'name';
						name.innerHTML = ctg.name

						let type = document.createElement('div');
						type.className = 'type';
						type.innerHTML = ctg.type;

						let color = document.createElement('div');
						color.className = 'color';
						color.style.backgroundColor = ctg.color;


						rowEl.appendChild(name);
						rowEl.appendChild(type);
						rowEl.appendChild(color);

						ctnAjax.appendChild(rowEl);

					})
				})




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


 
