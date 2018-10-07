/**
 * Calcul progression
 */
$(function () {
    $("#buro_service_metiermanagerbundle_groupe_nbrPersonne, #buro_service_metiermanagerbundle_groupe_nbrPersonneMax").change(function() {
        var _nbr_personne     = $("#buro_service_metiermanagerbundle_groupe_nbrPersonne").val();
        var _nbr_personne_max = $("#buro_service_metiermanagerbundle_groupe_nbrPersonneMax").val();

        $("#buro_service_metiermanagerbundle_groupe_nbrPersonne").attr('max', _nbr_personne_max);

        // Calcul
        var _nbr_progression = (parseInt(_nbr_personne) / parseInt(_nbr_personne_max)) * 100;
        $("#buro_service_metiermanagerbundle_groupe_progress").val(_nbr_progression);
    });

    $('#buro_service_metiermanagerbundle_groupe_nbrPersonne').on('keydown keyup', function(e) {
        var _nbr_personne_max = $("#buro_service_metiermanagerbundle_groupe_nbrPersonneMax").val();

        if ($(this).val() > parseInt(_nbr_personne_max)
            && e.keyCode != 46 // delete
            && e.keyCode != 8 // backspace
        ) {
            e.preventDefault();
            $(this).val(_nbr_personne_max);
            $('.maxQuantityMsg').show();
            $(this).addClass('maxQuantity').focus();
        }
    });
})