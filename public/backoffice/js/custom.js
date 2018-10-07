$(document).ready(function () {
    $('#input-1').rating();
    $('.rating-container').addClass('kl-star-custom');
    $('.rating-container').find('.star').addClass('kl-star');
    $('.rating-container').find('.caption').addClass('kl-star-caption');
    $('.rating-container').find('.clear-rating').addClass('kl-clear-rating');
    $('.table').find('.star').addClass('kl-star');
    $('.kl-td').find('.btn-primary').addClass('green');
    $('.select2-container').addClass('kl-select');
    $('.box-header').find('.box-title').addClass('kl-box-title');
    $('.box-body').find('h4').addClass('kl-custom-h4');
    $('.form-group').find('.col.s12').addClass('kl-custom-col');
    $('.box-footer').find('.btn').addClass('kl-btn-footer');
    $('.box-footer').addClass('text-right');
    $('.box-footer').find('.btn').removeClass('pull-left');
    $('.modal-body').find('.kl-body').addClass('kl-body-modal');
    $('.kl-resp-input').find('input').addClass('kl-resp-input-child');
    $('.kl-emp-input').find('input').addClass('kl-resp-input-child');
    $('.dataTables_processing').addClass('kl-chargement');

    $(window).resize(function () {
        if ($(window).width()<= 700){
            $('.kl-fct-show-content').text(' + Fonction');
        }
        if ($(window).width()<= 440 ){
            $('.kl-add-btn-top-list button').text('+ Nouveau ');
            $('.kl-delete-btn').text('Supprimer ');
        }
    });
    // $('.modal-body').mCustomScrollbar();
    // $('.modal-content').mCustomScrollbar();

    $( "#teste").validate( {
        rules: {
            "sekoliko_userbundle_user[usrFirstname]": "required",
            "sekoliko_userbundle_user[usrLastname]": "required",
            "sekoliko_userbundle_user[email]":"required",
            "sekoliko_userbundle_user[username]":"required",
            "sekoliko_userbundle_user[plainPassword][first]":"required",
            "sekoliko_userbundle_user[plainPassword][second]":"required"
        },
        messages: {
            "sekoliko_userbundle_user[usrLastname]": "Veuillez entrer votre nom",
            "sekoliko_userbundle_user[usrFirstname]": "Veuillez entrer votre prénom",
            "sekoliko_userbundle_user[email]": "Veuillez entrer votre email",
            "sekoliko_userbundle_user[username]": "Veuillez entrer votre nom d'utilisateur",
            "sekoliko_userbundle_user[plainPassword][first]": "Veuillez entrer votre mots de passe",
            "sekoliko_userbundle_user[plainPassword][second]": "Veuillez confirmé votre mots de passe",
        },
        errorElement: "em",
        errorPlacement: function ( error, element ) {
            // Add the `help-block` class to the error element
            error.addClass( "help-block" );

            if ( element.prop( "type" ) === "checkbox" ) {
                error.insertAfter( element.parent( "label" ) );
            } else {
                error.insertAfter( element );
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
        }
    } );

    $( "#id-ajax-modifier-absence" ).validate( {
    rules: {
        "usrAbsType": "required",
        "usrAbsMotif": "required",
        "usrAbsDateDebut":"required",
        "usrAbsDateFin":"required"
    },
    messages: {
        "usrAbsType": "Veuillez entrer le type d'absence",
        "usrAbsMotif": "Veuillez entrer un motif",
        "usrAbsDateDebut": "Veuillez entrer la date début",
        "usrAbsDateFin": "Veuillez entrer la date fin"
    },
    errorElement: "em",
    errorPlacement: function ( error, element ) {
        // Add the `help-block` class to the error element
        error.addClass( "help-block" );

        if ( element.prop( "type" ) === "checkbox" ) {
            error.insertAfter( element.parent( "label" ) );
        } else {
            error.insertAfter( element );
        }
    },
    highlight: function ( element, errorClass, validClass ) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-error" ).removeClass( "has-success" );
    },
    unhighlight: function (element, errorClass, validClass) {
        $( element ).parents( ".col-sm-5" ).addClass( "has-success" ).removeClass( "has-error" );
    }

    });
    $( '.modal' ).on('shown.bs.modal', function(){
        $('html').css('overflow-y','hidden');
    });
    $( '.modal' ).on('hidden.bs.modal', function(){
        $('html').css('overflow-y','auto');
    });
});

