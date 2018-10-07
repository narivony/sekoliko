$(document).ready(function () {
    var ajax_url_event_projet   = $('#calendar').data("ajax-url");
    var ajax_url_show_event     = $('#calendar').data("ajax-url-show");
    var defaut_projet_selected  = $('#calendar').data("projet-id");
    var selector_date_debut     = $('#lss_service_metiermanagerbundle_chauffeur_formation_cfrFrmDateDebut');
    var selector_conge_debut    = $('#lss_service_metiermanagerbundle_conge_cgDateDebut');
    var selector_absence_debut  = $('#lss_service_metiermanagerbundle_absence_absDateDebut');
    var selector_vstmed_debut   = $('#lss_service_metiermanagerbundle_visite_medicale_vstMedDate');
    var selector_trajet_debut   = $('#lss_service_metiermanagerbundle_vehicule_trajet_vhcTrDateDepart');
    var selector_driver_trajet  = '#lss_service_metiermanagerbundle_vehicule_trajet_lssChauffeur';
    var selector_driver_frm     = '#lss_service_metiermanagerbundle_chauffeur_formation_lssInfoChauffeur';
    var selector_driver_conge   = '#lss_service_metiermanagerbundle_conge_lssChauffeur';
    var selector_driver_vst_med = '#lss_service_metiermanagerbundle_visite_medicale_lssInfoChauffeur';

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay,listWeek'
        },
        defaultDate: $('#calendar').fullCalendar('today'),
        navLinks: true,
        editable: true,
        locale: 'fr',
        eventLimit: true,
        selectable: true,
        selectHelper: true,
        timeFormat: ' ',
        select: function (start, end) {
            var choisen_day  = moment(start).format("DD/MM/YYYY");
            var current_date = moment(new Date()).format("DD/MM/YYYY");

            if(choisen_day >= current_date)
            {
                $('#id-add-event, #id-add-event-vehicule').modal('show');

                selector_date_debut.val(moment(start).format("DD/MM/YYYY HH:mm"));
                selector_conge_debut.val(moment(start).format("DD/MM/YYYY HH:mm"));
                selector_absence_debut.val(moment(start).format("DD/MM/YYYY HH:mm"));
                selector_vstmed_debut.val(moment(start).format("DD/MM/YYYY HH:mm"));
                selector_trajet_debut.val(moment(start).format("DD/MM/YYYY HH:mm"));
                $('#id-formated-date').val(moment(start).format("YYYY/MM/DD HH:mm:ss"));
                $('#id-date-formatted-chauffeur-formation').val(moment(start).format("YYYY/MM/DD HH:mm:ss"))

                if(defaut_driver_selected > 0){
                    $(selector_driver_conge + ', ' + selector_driver_frm + ', ' + selector_driver_vst_med + ', ' + selector_driver_trajet)
                        .val(defaut_driver_selected);
                }

            }
        },
        events: function (start, end, timezone, callback) {
            var start_date = moment(start).format("YYYY-MM-DD HH:mm");
            var end_date   = moment(end).format("YYYY-MM-DD HH:mm");

            $.ajax({
                url: ajax_url_event_projet,
                dataType: 'json',
                data: {
                    projet_id: defaut_projet_selected,
                    date_debut: start_date,
                    date_fin: end_date
                },
                type: 'GET',
                success: function (response) {
                    var events = [];
                    $.each(response, function (key, value) {
                        events.push({
                            title: value.type,
                            backgroundColor: value.color,
                            start: value.date_debut,
                            end: value.date_fin,
                            data: value
                        });
                    });

                    callback(events);
                }
            });
        },
        eventRender: function(event, element) {
            element.popover({
                animation:true,
                html: true,
                delay: 200,
                content: setEventContent(event.data),
                trigger: 'click',
                placement: 'top',
                container: 'body',
            });
        }
    });

    $(document).on('click', '.kl-show-pop', function(e){
        var cible_type = $(this).data('type');
        var cible_id   = $(this).data('id');

        showContent(cible_type, cible_id);
    });

    $(document).on('click', function (e) {
        $('*.popover').each(function () {
            $('.popover').popover('hide');
        });
    });

    $('.kl-bloc-left-calendar a').click(function () {
        $('.kl-bloc-left-calendar a').removeClass('kl-active-nav-calendar');
        $(this).addClass('kl-active-nav-calendar');
    });

    $('.kl-mois').click(function () {
        $('.fc-month-button').trigger('click');
        return false;
    });

    $('.kl-semaine').click(function () {
        $('.fc-agendaWeek-button').trigger('click');
        return false;
    });

    $('.kl-jour').click(function () {
        $('.fc-agendaDay-button').trigger('click');
        return false;
    });

    $('.kl-liste').click(function () {
        $('.fc-listWeek-button').trigger('click');
        return false;
    });

    $('.kl-date').datepicker({
        format: 'mm/dd/yyyy',
        todayHighlight: true,
        autoclose: true,
        weekStart: 1,
        ignoreReadonly: true
    }).on('changeDate', function (ev) {
        $('#calendar').fullCalendar('gotoDate', ev.date);
    });

    /**
     * Ajout contenu dans detail modal
     * @param event
     * @returns {string}
     */
    function setEventContent(event) {
        var html = '<div class="kl-event-popover">' +
                        '<h4><a href="javascript:void(0)"  style="cursor: pointer;" class="kl-show-pop" data-type="'+event.desc_type+'" data-id="'+event.desc_id +'">'+ event.type +'</a></h4>' +
                        '<p>debuté le ' +
                            '<span data-type="'+event.cible_type+'" data-id="'+event.cible_id+'">' + event.cible +'</span> , prevue livré en ' +
                            '<span data-type="'+event.desc_type+'" data-id="'+event.desc_id +'"> '+ event.description +'</span>' +
                        '</p>' +
                        '<p class="kl-date-event">Statut : ' +
                            '<span> '+ event.statut +' </span> '
                        '</p>'
                   '</div>';
        return html;
    }

    /**
     * Afficher evenement
     * @param cible_type
     * @param cible_id
     */
    function showContent(cible_type, cible_id) {
        $.ajax({
            url: ajax_url_show_event,
            dataType: 'html',
            data: {cible_type: cible_type, cible_id: cible_id},
            type: 'GET',
            success: function (response) {
                $('.popover').popover('hide');
                $('#id-show-event').modal('show');
                $('#id-concent-event').html(response);
            }

        });
    }
});