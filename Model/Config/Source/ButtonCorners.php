<?php

declare(strict_types=1);

namespace Rezolve\InstantCheckout\Model\Config\Source;

use Magento\Framework\Data\OptionSourceInterface;

class ButtonCorners implements OptionSourceInterface
{
    public const VALUE_CORNER_ROUND = 'corner-round';
    public const VALUE_CORNER_ROUNDED = 'corner-rounded';
    public const VALUE_CORNER_SQUARE = 'corner-square';

    /**
     * Return array of options as value-label pairs
     *
     * @return array Format: array(array('value' => '<value>', 'label' => '<label>'), ...)
     */
    public function toOptionArray(): array
    {
        return [
            [
                'value' => self::VALUE_CORNER_ROUND,
                'label'=> __('Corner Round')
            ],
            [
                'value' => self::VALUE_CORNER_ROUNDED,
                'label' => __('Corner Rounded')],
            [
                'value' => self::VALUE_CORNER_SQUARE,
                'label' => __('Corner Square')
            ]
        ];
    }
}
