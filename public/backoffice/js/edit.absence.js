$(function () {

    $(document).on('click', '.kl-back-to-modifier-absence', function () {
        var dateFin = $('#sekoliko_user_absence_usrAbsDateFin').val();
        var max_date = moment(dateFin, "DD-MM-YYYY");
        $('#sekoliko_user_absence_usrAbsDateDebut').datetimepicker('maxDate', max_date);
        $('.kl-form-edit').show();
        $('.kl-detail-event').hide();
    });

    $(document).on('submit', '#id-ajax-modifier-absence', function (e) {
        e.preventDefault();

        var data = [];

        var url = $('#id-ajax-modifier-absence').attr('action');
        $('form#id-ajax-modifier-absence').find('input').each(function (key, value) {
            if (value.name != '') data[value.name] = value.value;
        })
        $('form#id-ajax-modifier-absence').find('select').each(function (key, value) {
            if (value.name != '') data[value.name] = value.value;
        })

        $.ajax({
            url: url,
            dataType: 'html',
            data: {
                usrAbsId: data.usrAbsId,
                usrAbsType: data.usrAbsType,
                usrAbsMotif: data.usrAbsMotif,
                usrAbsDateDebut: data.usrAbsDateDebut,
                usrAbsDateFin: data.usrAbsDateFin
            },
            type: 'POST',
            success: function (response) {
                $('#calendar').fullCalendar( 'refetchEvents' );
                $('.kl-form-edit').hide();
                $('.kl-detail-event').show();
                $('#id-concent-event').html(response);
            }
        });
    });
});