/**
 * verification tache lier user
 */
$(function () {

    var user_selector = $('#sekoliko_service_metiermanagerbundle_user_additionnel_sekolikoUser');
    var ajax_user_verification_url = user_selector.data('url-verification');

    user_selector.change(function (e) {
        var user_id = e.target.value;
        if (user_id > 0) tacheVerificationByUser(user_id, ajax_user_verification_url);
    });

    /**
     * Verifier si la tache est lier a un user
     * @param user_id
     * @param ajax_url
     */
    function tacheVerificationByUser(user_id, ajax_url) {

        $('#sekoliko_service_metiermanagerbundle_user_additionnel_sekolikoPrjLotTache option').prop('disabled', false);

        $.ajax({
            url: ajax_url,
            dataType: 'json',
            data: {user_id: user_id},
            type: 'GET',
            success: function (response) {
                disableTaches(response);
            }
        });
    }

    /**
     * Desactiver les options taches non disponible pour l user selectionnee
     * @param data
     */
    function disableTaches(data) {
        var option_tache  = "#sekoliko_service_metiermanagerbundle_user_additionnel_sekolikoPrjLotTache option[value='";
        var projet_tache_ids   = data.taches_ids;

        /** desactiver les taches indisponibles */
        projet_tache_ids.map(function (value) {
            $(option_tache + value + "']").attr('disabled', true);
        });
    }
});