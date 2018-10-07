/**
 * ajout utilisateur avec fonction
 */
$(function () {
    /** recupere les valeurs par defaut en cas de modification */
    var selected_fonction1 = $('#sekoliko_fonction1').val();
    var selected_fonction2 = $('#sekoliko_fonction2').val();
    var selected_fonction3 = $('#sekoliko_fonction3').val();
    var selected_fonction4 = $('#sekoliko_fonction4').val();
    var selected_fonction5 = $('#sekoliko_fonction5').val();

    /** enlever les fonctions deja pris dans les autres option */
    if (selected_fonction1 > 0) toggleSelect(selected_fonction1, 'sekoliko_fonction1');
    if (selected_fonction2 > 0) toggleSelect(selected_fonction1, 'sekoliko_fonction2');
    if (selected_fonction3 > 0) toggleSelect(selected_fonction1, 'sekoliko_fonction3');
    if (selected_fonction4 > 0) toggleSelect(selected_fonction1, 'sekoliko_fonction4');
    if (selected_fonction5 > 0) toggleSelect(selected_fonction1, 'sekoliko_fonction5');

    /** fonction d initialisation */
    showContentFonction(1);

    /** afficher une autre fonction */
    $('.kl-fct-show-content').click(function (e) {
        e.preventDefault();

        var cible_id = $(this).data('current-id') + 1;
        $(this).hide();

        showContentFonction(cible_id);
    });

    /** quand on choisi une fonction */
    $('select').change(function (e) {
       var value_id  = e.target.value;
       var target_id = e.target.id;

      toggleSelect(value_id, target_id);
    });

    /**
     * activer et desactiver une fonction dans l option
     * @param value_id
     * @param target_id
     */
    function toggleSelect(value_id, target_id) {
   //     $('select option[value=' + value_id + ']').attr('hidden',true);
        $('#' + target_id + ' option[value=' + value_id + ']').attr('hidden',false);
    }

    /**
     * afficher le bloc d ajout fonction
     * @param current_id
     */
    function showContentFonction(current_id) {
        $('#id-fct-content' + current_id).removeClass('hide');
        $('#sekoliko_fonction' + current_id).attr('required','required');
        $('#sekoliko_fonction_date_debut' + current_id).attr('required','required');
    }
});