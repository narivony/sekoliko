$(function () {
    $('body').delegate('.kl-lot', 'click', function(){
        var _id_statut = $(this).attr('id-statut');
        var _id_lot    = $(this).attr('id-lot');

        ajaxUpdateStatut(_id_statut, _id_lot);
    });
});

/**
 * Ajax update statut
 * @param _id_statut
 * @param _id_lot
 */
function ajaxUpdateStatut(_id_statut, _id_lot)
{
    // Chargement
    var _loading = "<b>Chargement...</b>";
    $("#id-lot-" + _id_lot).html(_loading);

    $.ajax({
        url: _url_update_statut_lot_ajax,
        dataType: "json",
        data: {
            id_statut: _id_statut,
            id_lot: _id_lot
        },
        type: "POST",
        success: function (response) {
            $("#id-lot-" + _id_lot).html(response.message);
            bootbox.alert("Statut modifié").find('.modal-body').addClass('kl-modal-bootbox');
        },
        error: function(xhr, statut, error) {
            /*
                bootbox.alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            */
            alert("Une erreur est survenue lors de l'opération. Veuillez réessayer.");
            var _error_message = "<b style='color: red'>Erreur</b>";
            $("#id-lot-" + _id_lot).html(_error_message);
        }
    });
}