$(document).ready(function() {

    // Header et footer js
    (function() {

        $(".login_header_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: $(this).attr('method'),
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    if (data.success === true) {
                        window.location.href = data.url;
                    } else {
                        var messagefr = "Email ou mot de passe incorrect";
                        $('#error_login_header').prepend('<div />').html(messagefr);
                    }
                }
            });
        });

        $("#newsletter_form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: $("#newsletter_form").attr('method'),
                url: Routing.generate('newsletter'),
                data: $("#newsletter_form").serialize(),
                success: function(data) {
                    var str = "Vous êtes déjà inscrit à la newsletter !";
                    if (data.message === 'success') {
                        str = "Vous êtes maintenant inscrit à la newsletter !";
                    }
                    $('#error_newsletter').html(str);
                }
            });
        });
    })();

    (function() {
        $('.bxslider').bxSlider({
            captions: true
        });
    })();

    // Caddie
    (function() {

        window.add = function add(nom) {
            if (document.getElementById(nom).value < 15) {
                document.getElementById(nom).value++;
            }
        };

        window.substract = function(nom) {
            if (document.getElementById(nom).value > 1)
                document.getElementById(nom).value--;
        };

        window.erase = function(nom) {
            document.getElementById(nom).value = 0;
        };

        window.isNumberKey = function(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57))
                return false;
            return true;
        };

        $('.quantite_cart').on('click', function() {
            $(this).parent().submit();
        });

        $('.caddie-table_garbage').on('click', function() {
            $(this).prev().submit();
        });

        $(".cart_form").submit(function(e) {
            e.preventDefault();
            var form = $(this);
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    $("." + form.attr("id")).html(form.find("input[type='text']").val() * data.prix);
                    updatePrixTotal();
                    $('#count_caddie').html(data.countcaddie);
                    if (data.html) {
                        $("." + form.attr("id")).parent().parent().remove();
                    }
                }
            });
        });

        function updatePrixTotal() {
            var prix_total = 0;
            $(".js-prixtotal").each(function() {
                prix_total += parseFloat($(this).text());
            });
            $(".cart_prixtotal").html(prix_total + " €");
            $(".cart_prixhttotal").html((prix_total * 0.945).toFixed(2) + " €");
        }

        var prix = 0;
        for (var i = 0; i < $('.js-prixtotal').length; i++) {
            prix += parseFloat($('.js-prixtotal')[i].innerHTML);
        }

    })();

    // Panier page
    (function() {
        $('.panier-popup_link').magnificPopup({
            type: 'inline',
            closeBtnInside: true,
            midClick: true // Allow opening popup on middle mouse click. Always set it to true if you don't provide alternative source in href.
        });

        $('.panier-popup_continue').on('click', function() {
            $.magnificPopup.close();
        });

        Date.prototype.toDateInputValue = (function() {
            var local = new Date(this);
            local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
            return local.toJSON().slice(0, 10);
        });
        $('#datePicker').val(new Date().toDateInputValue());

        // Mis à jour du prix du panier
        $('.quantite_button').on("click", function() {
            var prix = 89;
            if ($('#nbre_pers').val() === null || $('#nbre_pers').val() == 2) {
                prix = $('#update_prix').data('prix');
            }
            $('#update_prix').html($('#quantite').val() * prix);
        });

        $('#nbre_pers').on("change", function() {
            var prix = 89;
            if ($('#nbre_pers').val() === null || $('#nbre_pers').val() == 2) {
                prix = $('#update_prix').data('prix');
            }
            $('#update_prix').html($('#quantite').val() * prix);
            $('#update_pers').html($('#nbre_pers').val());
        });

        // Requete AJAX pour ajouter le produit au caddie
        $(".panier-form").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: 'post',
                url: $(this).attr('action'),
                data: $(this).serialize(),
                success: function(data) {
                    $('.panier-popup_photo').attr('src', $('.panier-popup_photo').data('src') + data.photo);
                    $('.panier-popup_quantite').html(data.quantite);
                    $('.panier-popup_titre').html(data.titre);
                    $('.panier-popup_link').trigger('click');
                    $('#count_caddie').html(data.countcaddie);
                }
            });
        });
    })();

    // ACCOUNT SECTION

    (function() {
        $('.account-table_buttonref').on('click', function() {
            var ref = $(this).text();
            $('.account-reftable').addClass('account-table-hide');
            $('#js-account-refbutton-' + ref).removeClass('account-table-hide');
        });
    })();

    // Le spinner du formulaire d'enregistrement
    (function() {
        if ($('.js-email')) {
            $('.js-email').on('change', function() {

                var $this = $(this);
                var delay = 2000; // 2 seconds delay after last input

                clearTimeout($this.data('timer'));

                $this.removeData('timer');
                $.ajax({
                    type: 'post',
                    url: Routing.generate('checkMail') + "/" + $(this).val(),
                    data: $(this).val(),
                    beforeSend: function() {
                        $('#js-emailspinner').empty().html('<span class="spinner-load"></span>');
                    },
                    success: function(data) {
                        var addSpinner = '<span class="content-sprite content-no"><p>Adresse e-mail déjà utilisée</p></span>';
                        if (data.message == 'success') {
                            addSpinner = '<span class="content-sprite content-ok"><p>Adresse e-mail disponible</p></span>';
                        } else if (data.message == 'novalidate') {
                            addSpinner = '<span class="content-sprite content-no"><p>Adresse e-mail incorrecte</p></span>';
                        }
                        $('#js-emailspinner').empty().html(addSpinner);
                    }
                });
            });
        }
    })();

    // Permet d'afficher le formulaire inmbriqué des adresses
    (function() {

        if ($('div#user_adresses').length !== 0) {

            // La fonction qui ajoute un formulaire Categorie
            var addAdresse = function($container) {
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
            };

            // La fonction qui ajoute un lien de suppression d'une catégorie
            var addDeleteLink = function($prototype) {
                // Création du lien
                var $deleteLink = $('<a href="#" class="userform_adresse-remove">Supprimer l\'adresse</a>');

                // Ajout du lien
                $prototype.append($deleteLink);

                // Ajout du listener sur le clic du lien
                $deleteLink.click(function(e) {
                    $prototype.remove();
                    e.preventDefault(); // évite qu'un # apparaisse dans l'URL
                    return false;
                });
            };

            $('#user_roles').find('option:nth-child(2)').attr('selected', 'selected');
            // On récupère la balise <div> en question qui contient l'attribut « data-prototype » qui nous intéresse.
            var $container = $('div#user_adresses');

            // On ajoute un lien pour ajouter une nouvelle catégorie
            var $addLink = $('<a href="#" class="userform_adresse-add">Ajouter une autre adresse de livraison</a>');
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
            if (index === 0) {
                return addAdresse($container);
            }

            // Pour chaque catégorie déjà existante, on ajoute un lien de suppression
            $container.children('div').each(function() {
                addDeleteLink($(this));
            });
        }
    })();
});
