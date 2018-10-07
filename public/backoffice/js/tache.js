$(function() {
    var ajax_url       = $('#id-form-tache').data('url');
    var selected_lot   = $('#sekolikoProjetLot').val();
    var waiting_status = $('#id-stt-waiting').val();

    if(waiting_status > 0)
        $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoProjetLotTacheStatut').val(waiting_status);

    $(document).on('change', '#sekoliko_service_metiermanagerbundle_fonction_sekolikoProjetLot, #sekolikoProjetLot', function (e) {
        var lot_id = e.target.value;

        listUsersByLot(lot_id, ajax_url);
    });

    $(document).on('click', '.kl-goto-content-form', function () {
        $('.kl-content-show').hide();
        $('.kl-content-form').show();
    });

    if (selected_lot > 0)
        listUsersByLot(selected_lot, ajax_url);

    $(document).on('submit', 'form#id-form-edit-tache', function (e) {
        e.preventDefault();

        var url_update = $('form#id-form-edit-tache').attr('action');
        var data = [];
        $('form#id-form-edit-tache').find('input').each(function (key, value) {
            if (value.name != '') {
                data[value.name] = value.value;
            }
        });

        $.ajax({
            url: url_update,
            dataType: 'html',
            type: 'POST',
            data: {
                'sekolikoTask': $('#sekolikoTask').val(),
                'sekolikoProjetLot': $('#sekolikoProjetLot').val(),
                'sekolikoUser': $('#sekolikoUser').val(),
                'sekolikoPrjLotTache': $('#sekolikoPrjLotTache').val(),
                'sekolikoProjetLotTacheStatut': $('#sekolikoProjetLotTacheStatut').val(),
                'prjLotTchDateAttribution': data.prjLotTchDateAttribution,
                'prjLotTchDateDebut': data.prjLotTchDateDebut,
                'prjLotTchDateFin': data.prjLotTchDateFin,
                'prjLotTchEstimationPers': data.prjLotTchEstimationPers,
                'prjLotTchEstimationResp': data.prjLotTchEstimationResp,
                'prjLotTchLibelle': data.prjLotTchLibelle,
                'prjLotTchDesc': $('#prjLotTchDesc').val()
            },
            success: function (response) {
                $('#id-all-content-task').html(response);
                $('#calendar').fullCalendar('refetchEvents');
            }
        });
    });

    /**
     * Lister les users dans un lot
     * @param lot_id
     * @param ajax_url
     */
    function listUsersByLot(lot_id, ajax_url) {
        $.ajax({
            url: ajax_url,
            dataType: 'json',
            data: {lot_id: lot_id},
            type: 'GET',
            success: function (response) {
                $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoUser, #sekolikoUser').html('');
                response.map(function (value) {
                    $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoUser, #sekolikoUser').append(
                        '<option value="' + value.id + '">' + value.libelle + '</option>'
                    );

                })
            }
        });
    }

});