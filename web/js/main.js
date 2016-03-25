$(document).ready(function(){

	var url = document.URL;
	$(".login_form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type        : $(this).attr( 'method' ),
			url         : $(this).attr( 'action' ),
			data        : $(this).serialize()
		})
		.done(function (data) {
			window.location.href = url;
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
				var messagefr = "Email ou mot de passe incorrect";
                $('#error_login_header').prepend('<div />').html(messagefr);
		});

	});

	$("#newsletter_form").submit(function(e){
		e.preventDefault();
		$.ajax({
			type: $("#newsletter_form").attr('method'),
			url:  $("#newsletter_form").attr('action'),
			data: $("#newsletter_form").serialize()
		})
		.done(function (data) {
			console.log(data.message);
			if ( data.message == 'Success' ) {
				$('#error_newsletter').html('Vous êtes maintenant inscrit à la newsletter !');
			}
			else {
				$('#error_newsletter').html('Vous êtes déjà inscrit à la newsletter !');
			}
		})
		.fail(function (jqXHR, textStatus, errorThrown) {
				$('#error_newsletter').html('Vous êtes déjà inscrit à la newsletter !');
		});
	});

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

	
});