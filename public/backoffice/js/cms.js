/**
 * CMS (plugins summernote)
 */
$(function () {
    var _id_input_fr = '#sekoliko_service_metiermanagerbundle_post_translations_fr_pstContent,' +
        '#sekoliko_service_metiermanagerbundle_cms_translations_fr_cmstContent';
    $(_id_input_fr).summernote({
        lang: 'fr-FR',
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });

    var _id_input_en = '#sekoliko_service_metiermanagerbundle_post_translations_en_pstContent,' +
        '#sekoliko_service_metiermanagerbundle_cms_translations_en_cmstContent';
    $(_id_input_en).summernote({
        height: 200,       // set editor height
        minHeight: null,   // set minimum height of editor
        maxHeight: null    // set maximum height of editor
    });
});