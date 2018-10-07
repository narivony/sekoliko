$(document).ready(function () {
    $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoPoles').select2();
    $('#sekoliko_service_metiermanagerbundle_projet_sekolikoProjetType').select2();
    $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoProjetLot').select2();
    $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoUser').select2();
    $('#sekoliko_service_metiermanagerbundle_fonction_sekolikoPrjLotTache').select2();
    $('#sekoliko_service_metiermanagerbundle_user_additionnel_sekolikoUser').select2();
    $('#sekoliko_service_metiermanagerbundle_user_additionnel_sekolikoPrjLotTache').select2();
    $('#sekoliko_service_metiermanagerbundle_projet_lot_sekolikoProjet').select2();
    $('#sekoliko_service_metiermanagerbundle_projet_lot_sekolikoProjetLotStatut').select2();
    $('#sekoliko_service_metiermanagerbundle_user_absence_sekolikoUser').select2();
    $('#sekoliko_service_metiermanagerbundle_user_absence_sekolikoUserAbsenceType').select2();
    $('#id-selection-utilisateur').select2();

    $('#sekoliko_fonction1,#sekoliko_fonction2,#sekoliko_fonction3,#sekoliko_fonction4,#sekoliko_fonction5,' +
        '#sekoliko_fonction6,#sekoliko_fonction7,#sekoliko_fonction8').each(function () {
        $(this).select2({
            allowClear:true,
        });
    });
});