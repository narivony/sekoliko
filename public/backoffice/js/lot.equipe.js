$(document).ready(function () {
    /** selecteur responsable 1 a 5 */
    var resp_selector = '#sekoliko_prj_lt_eqp_responsable1, #sekoliko_prj_lt_eqp_responsable2, #sekoliko_prj_lt_eqp_responsable3, ';
    resp_selector    += '#sekoliko_prj_lt_eqp_responsable4, #sekoliko_prj_lt_eqp_responsable5';
    /** selecteur employe 1 a 5 */
    var user_selector = '#sekoliko_prj_lt_eqp_emplye1, #sekoliko_prj_lt_eqp_emplye2, #sekoliko_prj_lt_eqp_emplye3, ';
    user_selector    += '#sekoliko_prj_lt_eqp_emplye4, #sekoliko_prj_lt_eqp_emplye5';

    /** on select select responsable 1 et emplye 1 */
    $(resp_selector).select2().on('select2:select', function (e) {
        e.preventDefault();

        var target_id = $(this).data('target-id');
        var data      = e.params.data;
        var resp_id   = data.id;
        $('#sekoliko_prj_lt_eqp_emplye' + target_id).find("option[value='" + resp_id + "']").remove();
    });
    $(user_selector).select2().on('select2:select', function (e) {
        e.preventDefault();

        var target_id = $(this).data('target-id');
        var data      = e.params.data;
        employe_id    = data.id;
        $('#sekoliko_prj_lt_eqp_responsable' + target_id).find("option[value='" + employe_id + "']").remove();
    });

    /** on unselect responsable 1 et emplye 1 */
    $(resp_selector).select2().on('select2:unselect', function (e) {
        e.preventDefault();

        var target_id   = $(this).data('target-id');
        var user_id     = e.params.data.id;
        var user_name   = e.params.data.text;
        var append_data = '<option value="' + user_id + '"> ' + user_name + '</option>';
        $('#sekoliko_prj_lt_eqp_emplye' + target_id).append(append_data);
    });
    $(user_selector).select2().on('select2:unselect', function (e) {
        e.preventDefault();

        var target_id   = $(this).data('target-id');
        var user_id     = e.params.data.id;
        var user_name   = e.params.data.text;
        var append_data = '<option value="' + user_id + '"> ' + user_name + '</option>';
        $('#sekoliko_prj_lt_eqp_responsable' + target_id).append(append_data);
    });
});
