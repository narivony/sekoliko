$('#sekoliko_service_metiermanagerbundle_fonction_sekolikoProjetLot').change(function (e) {
    var projet_lot_tache_id = e.target.value;
    var ajax_url  = $('#id-form-tache').data('url');
    listUsersByLot(projet_lot_tache_id, ajax_url);
})

var selected_lot = $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoProjetLot').val();
var ajax_url  = $('#id-form-tache').data('url');
if(selected_lot > 0){
    listUsersByLot(selected_lot, ajax_url);
}

/**
 * Lister les users dans un lot
 * @param projet_lot_tache_id
 * @param ajax_url
 */
function listUsersByLot(projet_lot_tache_id, ajax_url) {
    $.ajax({
        url: ajax_url,
        dataType: 'json',
        data: {projet_lot_tache_id: projet_lot_tache_id},
        type: 'GET',
        success: function (response) {
            $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoUser').html('');
            response.map(function (value) {
                $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoUser').append(
                    '<option value="'+value.id+'">'+value.libelle+'</option>'
                );
            })
        }
    });
}