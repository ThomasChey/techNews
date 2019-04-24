<?php
/**
 * Created by PhpStorm.
 * User: Etudiant
 * Date: 19/04/2019
 * Time: 12:23
 */

namespace App\Service\Twig;


use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class AppExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('summarize', function($contenu){

                // Suppression des balises HTML
                $string = strip_tags($contenu);

                // Si mon $string est supérieur à 150, je continue
                if (strlen($string) > 150) {

                    // Je m'assure de ne pas couper un mot.
                    // En recherchant la position du dernier espace.
                    $stringCut = substr($string, 0, 150);
                    $string = substr($stringCut, 0, strrpos($stringCut, ' '));
                }

                return $string . '...';

            }, array( 'is_safe' => array( 'html' ) ) )
        ];
    }

}