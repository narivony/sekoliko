
/*
 * Init Draggable Events
 */
var removeDraggable = $('#events-list [name=remove-draggable]');
$('#events-list .fc-event').each(function() {
    // store data so the calendar knows to render an event upon drop
    $(this).data('event', {
        title: $.trim($(this).text()), // use the element's text as the event title
        stick: true, // maintain when user navigates (see docs on the renderEvent method)
        className: this.className
    });

    $(this).draggable({
        zIndex: 999,
        revert: true, // will cause the event to go back to its
        revertDuration: 0 //  original position after the drag
    });
});


/*
 * Init Calendar
 */
$('.kl-calendar').fullCalendar({
    height: 400,
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay'
    },
    defaultDate: '2018-09-10',
    editable: true,
    droppable: true,
    drop: function() {
        // is the "remove after drop" checkbox checked?
        if (removeDraggable.is(':checked')) {
            // if so, remove the element from the "Draggable Events" list
            $(this).remove();
        }
    },
    events: [{
        title: 'All Day Event',
        start: '2018-09-01'
    }, {
        title: 'Long Event',
        start: '2015-02-07',
        end: '2018-09-10'
    }, {
        id: 999,
        title: 'Repeating Event',
        start: '2018-09-09T16:00:00'
    }]
});