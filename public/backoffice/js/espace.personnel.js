$(function () {
    var ajax_task       = $('#id-all-tasks').data('ajax-task');
    var ajax_task_alert = $('#id-all-tasks').data('ajax-task-alert');

    setSortableAndDroppable();

    current_task = $('.kl-task-inprogress .kl-portlet').data('task-id');

    if (current_task > 0) {
        getAlertTask(current_task);

        setInterval(function(){
            getAlertTask(current_task);
        }, 300000);
    }

    /**
     * configuration sortable et droppable
     * */
    function setSortableAndDroppable() {
        $(".kl-change-task").sortable({
            connectWith: ".kl-change-task",
            handle: ".kl-portlet-header",
            // cancel: ".kl-portlet-toggle",
            placeholder: "kl-portlet-placeholder ui-corner-all"
        });

        $(".kl-portlet")
            .addClass("ui-widget ui-widget-content ui-helper-clearfix ui-corner-all")
            .find(".kl-portlet-header")
            .addClass("ui-widget-header ui-corner-all");
            // .prepend("<span class='ui-icon ui-icon-minusthick kl-portlet-toggle'></span>");

        // $(".kl-portlet-toggle").on("click", function () {
        //     var icon = $(this);
        //     icon.toggleClass("ui-icon-minusthick ui-icon-plusthick");
        //     icon.closest(".kl-portlet").find(".kl-portlet-content").toggle();
        // });

        $('.kl-task-waiting').droppable({
            drop: function (event, ui) {
                var task_id = $(ui.draggable[0]).data('task-id');
                var task_type = $(ui.draggable[0]).data('task-type');
                $(this).removeClass('kl-on-over');

                if (task_type != 'waiting')
                    updateTask(task_id, task_type, 'attente');
            },
            over: function (event, ui) {
                $(this).addClass('kl-on-over');
            },
            out: function (event, ui) {
                $(this).removeClass('kl-on-over');
            }
        });

        $('.kl-task-inprogress').droppable({
            drop: function (event, ui) {
                var task_id = $(ui.draggable[0]).data('task-id');
                var task_type = $(ui.draggable[0]).data('task-type');
                $(this).removeClass('kl-on-over');

                if (task_type != 'inprogress')
                    updateTask(task_id, task_type, 'cours');
            },
            over: function (event, ui) {
                $(this).addClass('kl-on-over');
            },
            out: function (event, ui) {
                $(this).removeClass('kl-on-over');
            }
        });

        $('.kl-task-completed').droppable({
            drop: function (event, ui) {
                var task_id = $(ui.draggable[0]).data('task-id');
                var task_type = $(ui.draggable[0]).data('task-type');
                $(this).removeClass('kl-on-over');

                if (task_type != 'completed')
                    updateTask(task_id, task_type, 'termine');
            },
            over: function (event, ui) {
                $(this).addClass('kl-on-over');
            },
            out: function (event, ui) {
                $(this).removeClass('kl-on-over');
            }
        });
    }

    /**
     * mettre a jour le tache en cours
     * @param task_id
     * @param current_type
     * @param target_type
     */
    function updateTask(task_id, current_type, target_type) {
        $.ajax({
            url: ajax_task,
            dataType: 'html',
            type: 'POST',
            data: {
                task_id: task_id,
                current_statut: current_type,
                target_statut: target_type
            },
            beforeSend: function(event){
                $('.kl-loading-task').show();
            },
            complete: function(){
                $('.kl-loading-task').hide();
            },
            success: function (response) {
                $('#id-all-tasks').html(response);
                $('.kl-success-task').show().delay(5000).fadeOut('slow');
                setSortableAndDroppable();
            }
        });
    }

    /**
     * verifier l alerte du tache en cours
     * @param task_id
     */
    function getAlertTask(task_id) {
        $.ajax({
            url: ajax_task_alert,
            dataType: 'json',
            type: 'POST',
            data: {
                task_id: task_id
            },
            success: function (response) {
                if(response > 0 && response < 0.25){
                    $('.kl-aler-task-danger')
                        .show()
                        .html('Il ne vous reste plus que ' + (response * 60).toFixed(0) +' mn pour finaliser cette tâche')
                        .delay(9000).fadeOut('slow');
                }

                if(response < 0 && response > -0.5) {
                    $('.kl-aler-task-danger')
                        .show()
                        .html('Vous avez un retard de ' + (Math.abs(response * 60)).toFixed(0) +' mn pour cette tâche')
                        .delay(9000).fadeOut('slow');
                }
            }
        });
    }
});