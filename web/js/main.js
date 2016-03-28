$(document).ready(function(){

	// Header et footer js
	var header_footer = (function() {

		var url = document.URL;
		$(".login_form").submit(function(e){
			e.preventDefault();
			$.ajax({
				type        : $(this).attr( 'method' ),
				url         : $(this).attr( 'action' ),
				data        : $(this).serialize(),
				success: function (data) {
					if ( data.success == true ) {
						window.location.href = url;
					}
					else {
						var messagefr = "Email ou mot de passe incorrect";
						$('#error_login_header').prepend('<div />').html(messagefr);				
					}
				},
				error: function (jqXHR, textStatus, errorThrown) {
					console.log(errorThrown);
				}
			})
		})

		$("#newsletter_form").submit(function(e){
			e.preventDefault();
			$.ajax({
				type: $("#newsletter_form").attr('method'),
				url:  Routing.generate('newsletter'),
				data: $("#newsletter_form").serialize(),
				success: function (data) {
					if ( data.message == 'success' ) {
						$('#error_newsletter').html('Vous êtes maintenant inscrit à la newsletter !');
					}
					else {
						$('#error_newsletter').html('Vous êtes déjà inscrit à la newsletter !');
					}
				},	
				error: function (jqXHR, textStatus, errorThrown) {
					console.log("neinenienienenineinei");
				}
			});
		});
	})();

	var bxslider = (function() {
	 	$('.bxslider').bxSlider({
	            captions: true
	    });
	})();

	// Caddie
	var cart = (function() {

		add = function ( nom ) { 
			if(document.getElementById( nom ).value < 15) {
				document.getElementById( nom ).value ++;
			} 	
		};

		substract = function ( nom ) { 
			if(document.getElementById( nom ).value > 1)
				document.getElementById( nom ).value --; 
		} ;

		isNumberKey = function (evt) 
		{ 
			var charCode = (evt.which) ? evt.which : event.keyCode; 
			if (charCode > 31 && (charCode < 48 || charCode > 57)) 
				return false; 
			return true; 
		};

		$('.quantite_cart').on('click', function() {
			$(this).parent().submit();
		});

		$(".cart_form").submit(function(e) {
			e.preventDefault();
			var form = $(this);
			$.ajax({
				type: 'post',
				url:  $(this).attr('action'),
				data: $(this).serialize(),
				success: function (data) {
					$("." + form.attr("id")).html(form.find("input[type='text']").val() * data.prix);
					updatePrixTotal();
					$('#count_caddie').html(data.countcaddie);
				},	
				error: function (jqXHR, textStatus, errorThrown) {
					console.log("neinnienieneineinen");
				}
			});
		});				

		function updatePrixTotal() {
			var prix_total = 0;
			$(".test").each(function(index){
				prix_total += parseFloat($(this).text());
			});
			$(".cart_prixtotal").html(prix_total + " €");
		}

		updatePrixTotal();

		var prix = 0;
		for (var i=0; i < $('.test').length; i++) {
			prix += parseFloat($('.test')[i].innerHTML);
		}

	})();

	// Le spinner du formulaire d'enregistrement
	var spinnerlogin = (function () {
		if ($('.email_row')) {
			$('.email_row').on('change', function(){

			    var $this = $(this);
			    var delay = 2000; // 2 seconds delay after last input

			    clearTimeout($this.data('timer'));

			    $this.removeData('timer');
			    $.ajax({
			    	type: 'post',
			    	url: Routing.generate('checkMail') + "/" + $(this).val(),
			    	data: $(this).val(),
			    	beforeSend: function() {
			       		$('#spinner').html('encours');
			     	},
			   		success: function (data) {
			      		data.message == 'success' ? $('#spinner').html('Deja pris') : $('#spinner').html('libre');
			    	},
			    	error: function (jqXHR, textStatus, errorThrown, data) {
			      		console.log(errorThrown);
			    	}   
			  	});	
			});
		}
	})();

	// Permet d'afficher le formulaire inmbriqué des adresses
	var adressloginform = (function () {
		if (!$('div#user_adresses').length == 0) {

			$('#user_roles option:nth-child(2)').attr('selected', 'selected');
	        // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
	        var $container = $('div#user_adresses');

	        // On ajoute un lien pour ajouter une nouvelle catégorie
	        var $addLink = $('<a href="#" id="add_adresse" class="btn btn-default">Ajouter une autre adresse de livraison</a>');
	        $container.after($addLink);

	        // On ajoute un nouveau champ à chaque clic sur le lien d'ajout.
	        $addLink.click(function(e) {
	          addAdresse($container);
	          e.preventDefault(); // évite qu'un # apparaisse dans l'URL
	          return false;
	        });

	        // On définit un compteur unique pour nommer les champs qu'on va ajouter dynamiquement
	        var index = $container.find(':input').length;

	        // On ajoute un premier champ automatiquement s'il n'en existe pas déjà un (cas d'une nouvelle annonce par exemple).
	        if (index == 0) {
	          addAdresse($container);
	        } else {
	          // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
	          $container.children('div').each(function() {
	            addDeleteLink($(this));
	          }); 
	        }

	        // La fonction qui ajoute un formulaire Categorie
	        function addAdresse($container) 
	        {
	          // Dans le contenu de l'attribut « data-prototype », on remplace :
	          // - le texte "__name__label__" qu'il contient par le label du champ
	          // - le texte "__name__" qu'il contient par le numéro du champ
	          var $prototype = $($container.attr('data-prototype').replace(/__name__label__/g, ''));
	            

	          // On ajoute au prototype un lien pour pouvoir supprimer la catégorie
	          addDeleteLink($prototype);

	          // On ajoute le prototype modifié à la fin de la balise <div>
	          $container.append($prototype);

	          // Enfin, on incrémente le compteur pour que le prochain ajout se fasse avec un autre numéro
	          index++;
	        }

	        // La fonction qui ajoute un lien de suppression d'une catégorie
	        function addDeleteLink($prototype) 
	        {
	          // Création du lien
	          $deleteLink = $('<a href="#" id="erase_adresse" class="btn btn-danger">Supprimer l\'adresse</a>');

	          // Ajout du lien
	          $prototype.append($deleteLink);

	          // Ajout du listener sur le clic du lien
	          $deleteLink.click(function(e) 
	          {
	            $prototype.remove();
	            e.preventDefault(); // évite qu'un # apparaisse dans l'URL
	            return false;
	          });
	        }
    	}
	})();


});