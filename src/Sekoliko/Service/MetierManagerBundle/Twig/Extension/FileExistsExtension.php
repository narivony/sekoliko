<?php

namespace App\Sekoliko\Service\MetierManagerBundle\Twig\Extension;

/**
 * Class FileExistsExtension
 * @package App\Sekoliko\Service\MetierManagerBundle\Twig\Extension
 */
class FileExistsExtension extends \Twig_Extension
{
    /**
     * Return the functions registered as twig extensions
     *
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('file_exists', 'file_exists')
        );
    }

    /**
     * Récupérer le préfixe twig
     * @return string
     */
    public function getName()
    {
        return 'sekoliko_twig';
    }
}
