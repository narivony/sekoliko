/**
 * ajout utilisateur avec fonction
 */
$(function () {
    /** fonction d initialisation */
    showContentFonction(1);

    /** afficher une autre fonction */
    $('.kl-fct-show-content').click(function (e) {
        e.preventDefault();

        var cible_id = $(this).data('current-id') + 1;
        $(this).hide();

        showContentFonction(cible_id);
    });

    /**
     * afficher le bloc d ajout fonction
     * @param current_id
     */
    function showContentFonction(current_id) {
        $('#id-fct-content' + current_id).removeClass('hide');
        $('#sekoliko_projet_lot_statut' + current_id).attr('required','required');
        $('#sekoliko_projet_lot_prjLotNom' + current_id).attr('required','required');
        $('#sekoliko_projet_lot_prjLotAbr' + current_id).attr('required','required');
        $('#sekoliko_projet_lot_prjLotDesc' + current_id).attr('required','required');
        $('#sekoliko_projet_lot_prjLotDateDebut' + current_id).attr('required','required');
        $('#sekoliko_projet_lot_prjLotDatePrevLiv' + current_id).attr('required','required');
        $('#prjLotEqpNom' + current_id).attr('required','required');
        $('#sekoliko_prj_lt_eqp_responsable' + current_id).attr('required','required');
        $('#sekoliko_prj_lt_eqp_emplye' + current_id).attr('required','required');
    }
});