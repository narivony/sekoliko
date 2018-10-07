$(document).ready(function () {
    var ajax_url_event_developper  = $('#calendar').data("ajax-url");
    var ajax_url_show_event        = $('#calendar').data("ajax-url-show");
    var defaut_user_selected       = $('#calendar').data("user-id");

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
            var choisen_day  = moment(start).format("YYYY/MM/DD");
            var current_date = moment(new Date()).format("YYYY/MM/DD");
            var new_date_choisen = new Date(choisen_day);
            var new_date_current = new Date(current_date);

            if(new_date_choisen >= new_date_current)
            {
                $('#id-show-task-form').modal('show');

                $('#sekoliko_service_metiermanagerbundle_fonction_prjLotTchDateAttribution')
                    .val(moment(start).format("DD/MM/YYYY"));
            }
        },
        events: function (start, end, timezone, callback) {
            var start_date = moment(start).format("YYYY-MM-DD HH:mm");
            var end_date   = moment(end).format("YYYY-MM-DD HH:mm");

            $.ajax({
                url: ajax_url_event_developper,
                dataType: 'json',
                data: {
                    user_id: defaut_user_selected,
                    date_debut: start_date,
                    date_fin: end_date
                },
                type: 'GET',
                success: function (response) {
                    var events = [];
                    $.each(response, function (key, value) {
                        events.push({
                            title: value.description,
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

    $('.fc-button-group').find('.fc-button').addClass('kl-btn-fc');


    $('.fc-day-grid').find('.fc-row').addClass('kl-fc-row');

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
                        '<h4>'+ event.type +'</h4>' +
                        '<p>' +
                            '<strong  class="kl-show-pop" data-type="'+event.cible_type+'" data-id="'+event.cible_id+'">'+ event.cible +'</strong> tache : ' +
                            '<a href="javascript:void(0)" style="cursor: pointer;" class="kl-show-pop" data-type="'+event.desc_type+'" data-id="'+event.desc_id+'"> '+ event.description +'</a>' +
                        '</p>' +
                        '<p class="kl-date-event">du ' +
                            '<span> '+ event.popdate_debut +' </span> ' +
                            ' au <span> ' + event.popdate_fin + ' </span>' +
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
            data: {
                cible_type: cible_type,
                cible_id: cible_id
            },
            type: 'GET',
            success: function (response) {
                $('.popover').popover('hide');
                $('#id-show-event').modal('show');
                $('#id-concent-event').html(response);
            },
            error: function (response) {
            }
        });
    }
});