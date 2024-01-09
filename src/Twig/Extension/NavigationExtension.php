<?php

namespace App\Twig\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Twig\TwigFilter;
class NavigationExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [
            new TwigFunction('displayNavigation', [$this, 'displayNavigation']),
        ];
    }
    public function displayNavigation($currentPath)
{
    $segments = explode('/', $currentPath);
    $segments = array_filter($segments); // Remove empty segments

    if (empty($segments)) {
        return ''; // Return an empty string if there are no segments
    }

    $navigationHTML = '';
    $currentPath = '/';
    foreach ($segments as $index => $segment) {
        $currentPath .= $segment . '/';
        $decodedSegment = rawurldecode($segment);

        $listItem = '<li>';
        if ($index === 0) {
            $link = sprintf('<a href="/">Accueil</a>');
            $listItem .= $link;
        } elseif ($index !== count($segments) - 1) {
            $link = sprintf('<a href="%s">%s</a>', $currentPath, $decodedSegment);
            $listItem .= $link;
        } else {
            $listItem .= sprintf(
                '<span class="current-page">%s</span>',
                $decodedSegment
            );
        }
        $listItem .= '</li>';

        $navigationHTML .= $listItem;

        if ($index !== count($segments) - 1) {
            $separator = '<span class="separator">></span>';
            $navigationHTML .= $separator;
        }
    }

    return $navigationHTML;
}

}
class CustomFiltersExtension extends AbstractExtension
{
    public function getFilters()
    {
        return [
            new TwigFilter('rawurldecode', [$this, 'rawurldecodeFilter']),
        ];
    }

    public function rawurldecodeFilter($string)
    {
        return rawurldecode($string);
    }
}