<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model;

class ButtonStyles
{
    /**
     * @return string
     */
    public function prepareClasses(
        string $colour = '',
        string $height = '',
        string $corners = '',
        string $width = ''
    ): string {
        $classes = [];
        if (!empty($colour)) {
            $classes[] = $colour;
        }
        if (!empty($height)) {
            $classes[] = $height;
        }
        if (!empty($corners)) {
            $classes[] = $corners;
        }
        if (!empty($width)) {
            $classes[] = $width;
        }

        return implode(' ', $classes);
    }
}
