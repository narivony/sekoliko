/**
 * Récupération identifiant gestionnaire espace supprimé
 */
$(function () {
    $("#buro_service_metiermanagerbundle_space_userAdmins").on("select2:unselecting", function(event) {
        var _values  = $(this).val();
        $("#id-user-manager-remove").val(_values);
    });
})