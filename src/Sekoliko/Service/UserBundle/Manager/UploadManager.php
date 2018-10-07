<?php

namespace App\Sekoliko\Service\UserBundle\Manager;

use Doctrine\ORM\EntityManager;
use App\Sekoliko\Service\MetierManagerBundle\Utils\PathName;
use App\Sekoliko\Service\UserBundle\Entity\User;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UploadManager
{
    protected $_em;
    protected $_web_root;

    /**
     * UploadManager constructor.
     * @param EntityManager $_em
     * @param $_root_dir
     */
    public function __construct(EntityManager $_em, $_root_dir)
    {
        $this->_em       = $_em;
        $this->_web_root = realpath($_root_dir . '/../public');
    }
        
    /**
     * Suppression fichier (fichier avec entité)
     * @param integer $_id identifiant utilisateur
     * @return array
     */
    public function deleteImageById($_id)
    {
        $_user = $this->_em->getRepository('UserBundle:User')->find($_id);
        
        if ($_user) {
            try {
                $_path = $this->_web_root.$_user->getUsrPhoto();
        
                // Suppression du fichier
                @unlink($_path);

                // Suppression dans la base
                $_user->setUsrPhoto(null);
                $this->_em->persist($_user);
                $this->_em->flush();

                return array(
                    'success' => true
                );
            } catch (\Exception $_exc) {

                return array(
                    'success' => false,
                    'message' => $_exc->getTraceAsString()
                );
            }
        } else {

            return array(
                'success' => false,
                'message' => 'Image not found in database'
            );
        }
    }

    /**
     * Suppression fichier (uniquement le fichier)
     * @param integer $_id identifiant utilisateur
     * @return array
     */
    public function deleteOnlyImageById($_id)
    {
        $_user = $this->_em->getRepository('UserBundle:User')->find($_id);

        if ($_user) {
            $_path = $this->_web_root.$_user->getUsrPhoto();

            // Suppression du fichier
            @unlink($_path);
        }
    }
    
    /**
     * Upload fichier
     * @param User $_user
     * @param file $_image
     */
    public function upload(User $_user, $_image)
    {
        // Récupérer le répertoire fichier spécifique
        $_directory_image  = PathName::UPLOAD_IMAGE_USER;

        try {
            $_original_name = $_image->getClientOriginalName();
            $_path_part     = pathinfo($_original_name);
            $_extension     = $_path_part['extension'];
            $_filename      = md5(uniqid());

            $_filename_extension = $_filename . '.' . $_extension;
            $_uri_file           = $_directory_image . $_filename_extension;
            $_dir                = $this->_web_root . $_directory_image;
            $_image->move(
                $_dir,
                $_filename_extension
            );
            $_user->setUsrPhoto($_uri_file);
        } catch (\Exception $_exc) {
            throw new NotFoundHttpException("Erreur survenue lors de l'upload fichier");
        }
    }    
}