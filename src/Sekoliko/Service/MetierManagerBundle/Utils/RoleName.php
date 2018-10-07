<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Utils;

/**
 * Class RoleName
 * Classe qui contient les noms constante des rôles utilisateur
 */
class RoleName
{
    // Nom role
    const RESPONSABLE_RESSOURCES_HUMAINES = 'ROLE_RSP_RH';
    const RESPONSABLE_PROJET              = 'ROLE_RSP_PROJET';
    const RESPONSABLE_ADMINISTRATION      = 'ROLE_RSP_ADMINISTRATION';
    const RESPONSABLE_TECHNIQUE           = 'ROLE_RSP_TECHNIQUE';
    const PERSONNEL                       = 'ROLE_PERSONNEL';

    // Identifiant role
    const ID_ROLE_RSP_RH             = 1;
    const ID_ROLE_RSP_PROJET         = 2;
    const ID_ROLE_RSP_ADMINISTRATION = 3;
    const ID_ROLE_RSP_TECHNIQUE      = 4;
    const ID_ROLE_PERSONNEL          = 5;

    static $ROLE_TYPE = array(
        'ResponsableRH'             => 'ROLE_RSP_RH',
        'ResponsableProjet'         => 'ROLE_RSP_PROJET',
        'ResponsableAdministration' => 'ROLE_RSP_ADMINISTRATION',
        'ResponsableTechnique'      => 'ROLE_RSP_TECHNIQUE',
        'Personnel'                 => 'ROLE_PERSONNEL'
    );

    static $ID_VALEUR = array(
        1 => 'Responsable RH',
        2 => 'Responsable Projet',
        3 => 'Responsable Administration',
        4 => 'Responsable Technique',
        5 => 'Personnel'
    );
}
