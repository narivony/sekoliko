/**
 * Récupération liste activité par secteur
 */
function getAllActivityBySector() {
    // Récuperation url ajax
    var _url_ajax = $("#buro_service_metiermanagerbundle_sector").attr("ajax-url");

    $.ajax({
        type: "POST",
        url: _url_ajax,
        data: { 'id': _id_sector },
        cache: false,
        success: function(response) {
            if (response.success) {
                bootbox.alert("Suppression avec succès !").find('.modal-body').addClass('kl-modal-bootbox');
            } else {
                if (response.message) {
                    bootbox.alert(response.message).find('.modal-body').addClass('kl-modal-bootbox');
                }
            }
        }
    });
}