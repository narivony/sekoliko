$(function () {
    $('body').delegate('.kl-tache', 'click', function(){
        var _id_statut = $(this).attr('id-statut');
        var _id_tache  = $(this).attr('id-tache');

        ajaxUpdateStatut(_id_statut, _id_tache);
    });
});

/**
 * Ajax update statut
 * @param _id_statut
 * @param _id_tache
 */
function ajaxUpdateStatut(_id_statut, _id_tache)
{
    // Chargement
    var _loading = "<b>Chargement...</b>";
    $(".kl-statut-tache-" + _id_tache).html(_loading);

    $.ajax({
        url: _url_update_statut_tache_ajax,
        dataType: "json",
        data: {
            id_statut: _id_statut,
            id_tache: _id_tache
        },
        type: "POST",
        success: function (response) {
            $(".kl-statut-tache-" + _id_tache).html(response.message);
            bootbox.alert("Statut modifié avec envoie mail").find('.modal-body').addClass('kl-modal-bootbox');
        },
        error: function(xhr, statut, error) {
            bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.")
                .find('.modal-body').addClass('kl-modal-bootbox');
            var _error_message = "<b style='color: red'>Erreur</b>";
            $(".kl-statut-tache-" + _id_tache).html(_error_message);
        }
    });
}